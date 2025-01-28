<?php

namespace App\Http\Resources\Blogs;

use Illuminate\Http\Request;
use App\Http\Resources\Common\PaginationResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => PostResource::collection($this->collection),
            'pagination' => new PaginationResource($this)
        ];
    }
}
