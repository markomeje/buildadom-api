<?php

declare(strict_types=1);

namespace App\Traits\Order;
use App\Models\Order\Order;
use App\Models\Order\OrderFulfillment;

trait OrderFulfillmentTrait
{
    /**
     * @return OrderFulfillment
     */
    public function saveOrderFulfillment(Order $order, string $confirmation_code)
    {
        $order_id = $order->id;

        return OrderFulfillment::updateOrCreate([
            'order_id' => $order_id,
            'is_confirmed' => 0,
            'customer_id' => $order->customer_id,
        ], [
            'order_id' => $order_id,
            'is_confirmed' => 0,
            'customer_id' => $order->customer_id,
            'confirmation_code' => $confirmation_code,
            'reference' => str()->uuid(),
        ]);
    }
}
