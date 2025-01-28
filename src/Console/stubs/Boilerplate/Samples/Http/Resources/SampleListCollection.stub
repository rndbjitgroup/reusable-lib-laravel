<?php

namespace App\Http\Resources\Samples;

use App\Http\Resources\Commons\PaginationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SampleListCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => SampleListResource::collection($this->collection) 
        ];
    }
}
