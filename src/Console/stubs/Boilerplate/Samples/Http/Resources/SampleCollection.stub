<?php

namespace App\Http\Resources\Samples;

use App\Http\Resources\Common\PaginationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SampleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => SampleResource::collection($this->collection),
            'pagination' => new PaginationResource($this)
        ];
    }
}
