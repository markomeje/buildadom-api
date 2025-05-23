<?php

namespace App\Http\Resources\V1\Customer\Order;
use App\Http\Resources\V1\Order\OrderResource;
use App\Http\Resources\V1\Payment\PaymentResource;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class OrderPaymentResource extends JsonResource
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
            'order' => new OrderResource($this->whenLoaded('order')),
            'payment' => new PaymentResource($this->whenLoaded('payment')),
        ];
    }
}
