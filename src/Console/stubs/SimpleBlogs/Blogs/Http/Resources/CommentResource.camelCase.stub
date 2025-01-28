<?php

namespace App\Http\Resources\Blogs;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'parentId' => $this->parentId,
            'comment' => $this->comment,
            'replies' => CommentResource::collection($this->replies)
        ];
    }
}
