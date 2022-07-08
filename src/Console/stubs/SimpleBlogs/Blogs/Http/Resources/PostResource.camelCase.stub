<?php

namespace App\Http\Resources\Blogs;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'category' => new CategoryResource($this->category),
            'slug' => $this->slug,
            'title' => $this->title,
            'body' => $this->body, 
            'basePath' => config('app.url') . '/' . config('constants.path.storage'),
            'imagePath' => $this->image_path, 
            'thumbnailPath' => $this->thumbnail_path, 
            'comments' => CommentResource::collection($this->comments),
            'publishedAt' => $this->published_at, 
            'createdAt' => $this->created_at, 
            'updatedAt' => $this->updated_at, 
        ];
    }
}
