<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Commons\PaginationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserListCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => UserListResource::collection($this->collection) 
        ];
    }
}
