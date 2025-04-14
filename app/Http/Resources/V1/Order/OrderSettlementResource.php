<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Order;
use App\Http\Resources\CurrencyResource;
use App\Http\Resources\V1\Payment\PaymentResource;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class OrderSettlementResource extends JsonResource
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
            'description' => $this->description,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'currency' => new CurrencyResource($this->whenLoaded('currency')),
            'order' => new OrderResource($this->whenLoaded('order')),
            'payment' => new PaymentResource($this->whenLoaded('payment')),
        ];
    }
}
