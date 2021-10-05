<?php

namespace App\Http\Resources\Samples;

use App\Http\Resources\Common\PaginationResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SampleCollection extends ResourceCollection
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
            'data' => SampleResource::collection($this->collection),
            'pagination' => new PaginationResource($this)
        ];
    }
}
