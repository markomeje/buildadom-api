<?php

namespace App\Http\Resources\V1\Customer\Order;
use App\Http\Resources\CurrencyResource;
use App\Http\Resources\V1\Customer\Payment\PaymentResource;
use App\Http\Resources\V1\OrderTrackingResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
      'tracking_number' => $this->tracking_number,
      'total_amount' => $this->total_amount,
      'product_id' => $this->product_id,
      'amount' => $this->amount,
      'customer_id' => $this->customer_id,
      'quantity' => $this->quantity,
      'currency_id' => $this->currency_id,
      'store_id' => $this->store_id,
      'status' => $this->status,
      'currency' => new CurrencyResource($this->whenLoaded('currency')),
      'payment' => new PaymentResource($this->whenLoaded('payment')),
      'trackings' => OrderTrackingResource::collection($this->whenLoaded('trackings'))
    ];
  }
}
