<?php

namespace App\Http\Resources\Products;

use App\Http\Resources\Common\PaginationResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
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
            'data' => ProductResource::collection($this->collection),
            'pagination' => new PaginationResource($this)
        ];
    }
}
