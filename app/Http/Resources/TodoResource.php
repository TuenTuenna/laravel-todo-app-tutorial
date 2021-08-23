<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        - 할일
//        - 제목 : string required
//        - 내용 : longtext optional
//        - 마감기한 : date optional
//        - 완료여부 : boolean default false
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'deadline' => ($this->deadline == null) ? "마감기한이 정해져 있지 않습니다." : date('Y-m-d', strtotime($this->deadline)),
            'isDone' => $this->isDone,
            'updated_at' => $this->updated_at->diffForHumans() . " 전에 수정되었습니다.",
        ];
    }
}
