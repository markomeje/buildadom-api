<?php

declare(strict_types=1);

namespace App\Traits\Order;
use App\Enums\Order\OrderStatusEnum;

trait OrderTrackingTrait
{
    /**
     * @return string
     */
    private function getNextOrderTrackingStatus(string $current_status)
    {
        if ($current_status == OrderStatusEnum::PLACED->value) {
            $next_status = OrderStatusEnum::PROCESSED->value;
        } elseif ($current_status == OrderStatusEnum::ACCEPTED->value) {
            $next_status = OrderStatusEnum::PROCESSED->value;
        } elseif ($current_status == OrderStatusEnum::PROCESSED->value) {
            $next_status = OrderStatusEnum::DISPATCHED->value;
        } else {
            $next_status = OrderStatusEnum::FULFILLED->value;
        }

        return $next_status;
    }
}
