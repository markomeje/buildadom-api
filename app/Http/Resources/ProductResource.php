<?php

namespace App\Http\Resources;

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
    $attributes = $this->attributes;
    $attributes = empty($attributes) ? null : explode('|', $attributes);
    return [
      'id' => $this->id,
      'name' => ucwords($this->name),
      'description' => $this->description,
      'store_id' => $this->store_id,
      'status' => $this->status,
      'category_id' => $this->category_id,
      'price' => $this->price,
      'quantity' => $this->quantity,
      'user_id' => $this->user_id,
      'attributes' => $attributes,
    ];
  }
}
