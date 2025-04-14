<?php

declare(strict_types=1);

namespace App\Http\Resources\Admin;
use App\Http\Resources\CurrencyResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class PaymentListResource extends JsonResource
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
            'type' => $this->type,
            'account_type' => $this->account_type,
            'transfer_code' => $this->transfer_code,
            'status' => $this->status,
            'reference' => $this->reference,
            'message' => $this->message,
            'currency' => new CurrencyResource($this->whenLoaded('currency')),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
