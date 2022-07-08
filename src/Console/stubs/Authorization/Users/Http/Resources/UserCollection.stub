<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Common\PaginationResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
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
            'data' => UserResource::collection($this->collection),
            'pagination' => new PaginationResource($this)
        ];
    }
}
