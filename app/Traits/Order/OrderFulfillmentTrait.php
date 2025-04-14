<?php

namespace App\Traits\Order;
use App\Enums\Order\OrderFulfillmentStatusEnum;
use App\Enums\Order\OrderStatusEnum;
use App\Models\Order\Order;
use App\Models\Order\OrderFulfillment;
use App\Utility\Status;
use Carbon\Carbon;
use Exception;

trait OrderFulfillmentTrait
{
    /**
     * @param Order $order
     * @param string $confirmation_code
     * @return OrderFulfillment
     */
    public function saveOrderFulfillment(Order $order, string $confirmation_code)
    {
        $order_id = $order->id;
        return OrderFulfillment::updateOrCreate([
            'order_id' => $order_id,
            'is_confirmed' => 0,
            'customer_id' => $order->customer_id
        ], [
            'order_id' => $order_id,
            'is_confirmed' => 0,
            'customer_id' => $order->customer_id,
            'confirmation_code' => $confirmation_code,
            'reference' => str()->uuid()
        ]);
    }


}
