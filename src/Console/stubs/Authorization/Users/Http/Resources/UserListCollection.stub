<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Commons\PaginationResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserListCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => UserListResource::collection($this->collection) 
        ];
    }
}
