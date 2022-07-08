<?php

namespace App\Http\Resources\Samples;

use App\Http\Resources\Commons\PaginationResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SampleListCollection extends ResourceCollection
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
            'data' => SampleListResource::collection($this->collection) 
        ];
    }
}
