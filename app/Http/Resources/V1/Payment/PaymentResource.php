<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Payment;
use App\Http\Resources\CurrencyResource;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'fee' => $this->fee,
            'total_amount' => $this->total_amount,
            'account_type' => $this->account_type,
            'status' => $this->status,
            'reference' => $this->reference,
            'currency' => new CurrencyResource($this->whenLoaded('currency')),
        ];
    }
}
