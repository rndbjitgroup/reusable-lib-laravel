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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
