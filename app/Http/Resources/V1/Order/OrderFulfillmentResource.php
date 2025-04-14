<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Order;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class OrderFulfillmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
