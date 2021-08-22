<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

//        # 디비 구조
//        - 할일
//        - 제목 : string required
//        - 내용 : longtext optional
//        - 마감기한 : date optional
//        - 완료여부 : boolean default false

        return [
            'title' => 'required|max:50',
            'content' => 'max:255',
            'deadline' => 'date',
            'isDone' => 'required|boolean',
        ];
    }
}
