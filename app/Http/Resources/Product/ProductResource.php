<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\CurrencyResource;
use App\Http\Resources\Product\ProductCategoryResource;
use App\Http\Resources\Product\ProductImageResource;
use App\Http\Resources\Product\ProductUnitResource;
use App\Http\Resources\Store\StoreResource;
use App\Models\Product\ProductCategory;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'name' => ucwords($this->name),
      'description' => $this->description,
      'status' => $this->status,
      'price' => $this->price,
      'quantity' => $this->quantity,
      'published' => $this->published,
      'images' => ProductImageResource::collection($this->whenLoaded('images')),
      'category' => new ProductCategoryResource($this->whenLoaded('category')),
      'unit' => new ProductUnitResource($this->whenLoaded('unit')),
      'currency' => new CurrencyResource($this->whenLoaded('currency')),
      'store' => new StoreResource($this->whenLoaded('store')),
    ];
  }
}
