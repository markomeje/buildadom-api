<?php

namespace App\Http\Resources\V1\Customer\Order;
use App\Http\Resources\V1\Customer\Payment\PaymentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderPaymentResource extends JsonResource
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
      'order_id' => $this->order_id,
      'order' => new OrderResource($this->whenLoaded('order')),
      'payment_id' => $this->payment_id,
      'payment' => new PaymentResource($this->whenLoaded('payment')),
    ];
  }
}
