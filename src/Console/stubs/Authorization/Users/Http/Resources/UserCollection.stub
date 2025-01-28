<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Common\PaginationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => UserResource::collection($this->collection),
            'pagination' => new PaginationResource($this)
        ];
    }
}
