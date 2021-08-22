<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// 출처 라라캐스트
// https://laracasts.com/discuss/channels/laravel/how-can-i-remove-links-and-meta-from-resourcecollection-response
class Paginate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $response = $next($request);

        $data = $response->getData(true);

        if (isset($data['links'])) {
            unset($data['links']); // links 는 빼주세요
        }

        if (isset($data['meta'], $data['meta']['links'])) {
            unset($data['meta']['links']); // meta 안에 links 는 빼주세요
        }

        $response->setData($data);

        return $response;
    }
}
