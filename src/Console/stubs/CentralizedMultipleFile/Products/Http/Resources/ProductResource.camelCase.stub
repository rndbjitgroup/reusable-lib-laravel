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
            'productCategory' => new ProductCategoryResource($this->product_category),
            'title' => $this->title,
            'slug' => $this->slug, 
            'identifierUrl' => $this->identifier_url,
            'description' => $this->description,
            'size' => $this->size,
            'color' => $this->color,
            'oldPrice' => $this->old_price,
            'price' => $this->price,
            'coupon' => $this->coupon,
            'publishedAt' => $this->published_at,
            'files' => FileResource::collection($this->files->fresh()),
            'tags' => TagResource::collection($this->tags),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at, 
        ];
    }
}
