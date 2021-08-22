<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @group 포스트 관리
 *
 * APIs for managing posts
 * 포스트를 관리합니다.
 */
class TodoController extends Controller
{
    /**
     * Get a list of posts
     *
     * 포스트 리스트 가져오기
     * <aside class="notice">We mean it; you really should.😕</aside>
     *
     * @queryParam page integer 페이지 Example: 1
     * @responseFile status=200 scenario="성공" responses/todos.get.json
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return TodoResource::collection(Todo::orderBy('updated_at', 'desc')->paginate(5));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * add a new todo
     *
     * 포스트 추가하기
     * <aside class="notice">We mean it; you really should.😕</aside>
     * @responseFile status=201 scenario="success" responses/todo.post.json
     * @responseFile status=201 scenario="마감기한이 정해져 있지 않을 때" responses/todo.get.without_deadline.json
     * @responseFile status=422 scenario="데이터가 유효하지 않을 때" responses/todo.invalid.json
     * @param TodoRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoRequest $request)
    {
        $userInput = $request->all();

        $newTodo = Todo::create($userInput);

        return new TodoResource($newTodo);

    }

    /**
     * get a todo
     *
     * 특정 할일 가져오기
     *
     * <aside class="notice">urlParam 에 대한 설명</aside>
     * @urlParam id integer required 할일 아이디 Example: 10
     * /**
     * @responseFile status=200 scenario="success" responses/todo.get.json
     * @responseFile status=200 scenario="마감기한이 정해져 있지 않을때" responses/todo.get.without_deadline.json
     * @responseFile status=404 scenario="todo not found" responses/todo.not_found.json
     *
     */
    public function show($id)
    {
        if (Todo::where('id', $id)->exists()) {
            return new TodoResource(Todo::find($id));
        } else {
            return response()->json([
                "message" => "해당 할일을 찾을 수가 없습니다."
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update a todo
     *
     * 특정 할일 수정하기
     * <aside class="notice">We mean it; you really should.😕</aside>
     * @urlParam id integer required 할일 아이디 Example: 10
     * @responseFile status=200 scenario="success" responses/todo.post.json
     * @responseFile status=404 scenario="todo not found" responses/todo.not_found.json
     * @responseFile status=422 scenario="데이터가 유효하지 않을 때" responses/todo.invalid.json
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TodoRequest $request, $id)
    {
        if (Todo::where('id', $id)->exists()) {
            $fetchedTodo = Todo::find($id);

            $fetchedTodo->update($request->all());

            return new TodoResource($fetchedTodo);

        } else {
            return response()->json([
                "message" => "해당 할일을 찾을 수가 없습니다."
            ], Response::HTTP_NOT_FOUND);
        }

    }

    /**
     * Remove a todo
     *
     * 특정 할일 삭제하기
     * <aside class="notice">We mean it; you really should.😕</aside>
     * @urlParam id integer required 할일 아이디 Example: 10
     * @response status=204 scenario="success" {}
     * @responseFile status=404 scenario="todo not found" responses/todo.not_found.json
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (Todo::where('id', $id)->exists()) {
            $fetchedTodo = Todo::find($id);

            $fetchedTodo->delete();
            return response()->json([
                "message" => "해당 할일이 삭제되었습니다."
            ], Response::HTTP_NO_CONTENT);

        } else {
            return response()->json([
                "message" => "해당 할일을 찾을 수가 없습니다."
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
