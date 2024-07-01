<?php

namespace App\Http\Resources\V1\Customer\Payment;
use App\Http\Resources\CurrencyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
      'amount' => $this->amount,
      'status' => $this->status,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
      'currency' => new CurrencyResource($this->whenLoaded('currency')),
    ];
  }
}
