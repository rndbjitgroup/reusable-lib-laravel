<?php

namespace App\Http\Resources\Samples;

use Illuminate\Http\Resources\Json\JsonResource;

class SampleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id, 
            'name' => $this->name, 
            'detail' => $this->detail,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
