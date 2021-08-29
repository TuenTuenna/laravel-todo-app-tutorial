<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @group 검색
 *
 * APIs for search todos
 * 할일을 검색합니다.
 */
// 검색 처리 컨트롤러
class SearchController extends Controller
{
    /**
     * Search todo
     *
     * 할일 검색하기
     * <aside class="notice">We mean it; you really should.😕</aside>
     * @queryParam query string 검색어 Example: 안녕
     * @queryParam page integer 페이지 Example: 1
     *
     * @responseFile storage/responses/todos.get.json
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $results = [];

        // 요청에 query 라는 키가 들어 있다면
        if ($query = $request->get('query')){

//            $results = Todo::search($query)->paginate(3);

            $results = Todo::search($query, function($meilisearch, $query, $options) use ($request) {
                $rankingRules = $meilisearch->getRankingRules();

                $updated_desc_ranking = 'desc(updated_at_timestamp)';

                if (!in_array($updated_desc_ranking, $rankingRules)){
                    $meilisearch->updateRankingRules(
                        [
                            'desc(updated_at_timestamp)'
                        ]
                    );
                }

                return $meilisearch->search($query, $options);
            })->paginate(3);

            return response()->json([
                'data' => TodoResource::collection($results->items()),
                'meta' => [
                    'current_page' => $results->currentPage(),
                    'last_page' => $results->lastPage(),
                    'path' => $results->path(),
                    'per_page' => $results->perPage(),
                    'hasMorePages' => $results->hasMorePages(),
                    'total' => $results->total(),
                ]
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'results' => null
            ], Response::HTTP_NO_CONTENT);
        }
    }

}
