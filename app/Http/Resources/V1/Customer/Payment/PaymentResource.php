<?php

namespace App\Http\Resources\V1\Customer\Payment;
use App\Http\Resources\CurrencyResource;
use App\Http\Resources\V1\Escrow\EscrowAccountResource;
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
      'amount' => $this->amount,
      'status' => $this->status,
      'currency' => new CurrencyResource($this->whenLoaded('currency')),
    ];
  }
}
