<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Resources\Json\JsonResource;

class PaginationResource extends JsonResource
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
            'current_page' => $this->currentPage(),
            'per_page' => $this->perPage(),
            'total' => $this->total(), 
            'prev_page_url' => $this->previousPageUrl(),
            'next_page_url' => $this->nextPageUrl(),
            'options' => $this->getOptions(), 
            'total_pages' => $this->lastPage()
        ];
    }
}
