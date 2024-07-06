<?php

namespace App\Traits\V1\Order;
use App\Enums\Order\OrderDeliveryStatusEnum;
use App\Enums\Order\OrderStatusEnum;
use App\Models\Order\Order;
use App\Models\Order\OrderDelivery;
use App\Utility\Status;
use Exception;

trait OrderTrackingTrait
{
  /**
   * @param Order $order
   * @return OrderDelivery
   */
  public function saveOrderDelivery(Order $order, int $confirmation_code)
  {
    $order_id = $order->id;
    return OrderDelivery::updateOrCreate([
      'order_id' => $order_id,
      'status' => OrderDeliveryStatusEnum::PENDING->value,
      'customer_id' => $order->customer_id
    ], [
      'order_id' => $order_id,
      'is_confirmed' => 0,
      'customer_id' => $order->customer_id,
      'status' => OrderDeliveryStatusEnum::PENDING->value,
      'confirmation_code' => $confirmation_code,
      'reference' => str()->uuid()
    ]);
  }

  /**
   * @param string $current_status
   * @return string
   */
  private function getNextOrderTrackingStatus(string $current_status)
  {
    if($current_status == OrderStatusEnum::PLACED->value) {
      $current_status = OrderStatusEnum::PROCESSED->value;
    }elseif($current_status == OrderStatusEnum::ACCEPTED->value) {
      $current_status = OrderStatusEnum::PROCESSED->value;
    }elseif($current_status == OrderStatusEnum::PROCESSED->value) {
      $current_status = OrderStatusEnum::DISPATCHED->value;
    }else {
      $current_status = OrderStatusEnum::DELIVERED->value;
    }

    return $current_status;
  }

  /**
   * @param string $current_status
   * @throws Exception
   * @return void
   */
  public function handleOrderTrackingChecks(string $current_status)
  {
    if($current_status == strtolower(OrderStatusEnum::DELIVERED->value)) {
      throw new Exception('Order has already been delivered.', Status::HTTP_NOT_ACCEPTABLE);
    }elseif($current_status == strtolower(OrderStatusEnum::DECLINED->value)) {
      throw new Exception('Order has already been declined.', Status::HTTP_NOT_ACCEPTABLE);
    }elseif($current_status == strtolower(OrderStatusEnum::PLACED->value)) {
      throw new Exception('You need to accept or decline the order first.', Status::HTTP_NOT_ACCEPTABLE);
    }
  }

}