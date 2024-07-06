<?php

namespace App\Http\Resources\V1\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDeliveryResource extends JsonResource
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
      'payment_authorized' => $this->payment_authorized,
      'confirmation_code' => $this->confirmation_code,
      'payment_processed' => $this->payment_processed,
      'is_confirmed' => $this->is_confirmed,
      'status' => $this->status,
    ];
  }
}
