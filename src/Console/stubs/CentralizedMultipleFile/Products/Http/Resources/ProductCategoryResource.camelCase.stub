<?php

namespace App\Http\Resources\Products;

use App\Enums\CmnEnum;
use App\Http\Resources\Common\FileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $fileIndex = CmnEnum::ZERO;
        if (isset($this->files) && count($this->files) > CmnEnum::ZERO) {
            $fileIndex = count($this->files) - 1;   
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'file' =>  new FileResource($this->files[$fileIndex] ?? null),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at, 
        ];

    }
}
