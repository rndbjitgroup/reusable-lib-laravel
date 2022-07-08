<?php

namespace App\Http\Resources\Blogs;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'parentId' => $this->parentId,
            'comment' => $this->comment,
            'replies' => CommentResource::collection($this->replies)
        ];
    }
}
