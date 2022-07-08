<?php

namespace App\Http\Resources\Products;

use App\Http\Resources\Common\FileResource; 
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'product_category' => new ProductCategoryResource($this->product_category),
            'title' => $this->title,
            'slug' => $this->slug, 
            'identifier_url' => $this->identifier_url,
            'description' => $this->description,
            'size' => $this->size,
            'color' => $this->color,
            'old_price' => $this->old_price,
            'price' => $this->price,
            'coupon' => $this->coupon,
            'published_at' => $this->published_at,
            'files' => FileResource::collection($this->files->fresh()),
            'tags' => TagResource::collection($this->tags),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at, 
        ];
    }
}
