<?php

namespace App\Http\Resources\V1\Escrow;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class EscrowBalanceResource extends JsonResource
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
            'old_balance' => $this->old_balance,
            'amount' => $this->amount,
            'new_balance' => $this->new_balance,
            'balance_type' => $this->balance_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
