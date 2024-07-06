<?php

namespace App\Traits\V1\Order;
use App\Enums\Order\OrderDeliveryStatusEnum;
use App\Enums\Order\OrderStatusEnum;
use App\Models\Order\Order;
use App\Models\Order\OrderDelivery;
use App\Utility\Status;
use Exception;

trait OrderDeliveryTrait
{
  /**
   * @param Order $order
   * @param string $confirmation_code
   * @return OrderDelivery
   */
  public function saveOrderDelivery(Order $order, string $confirmation_code)
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
   * @param OrderDelivery $order_delivery
   * @throws Exception
   * @return void
   */
  public function handleDeliveredOrderConfirmationChecks(OrderDelivery $order_delivery)
  {
    if(empty($order_delivery)) {
      throw new Exception('Order delivery record not found.', Status::HTTP_NOT_FOUND);
    }elseif($order_delivery->is_confirmed) {
      throw new Exception('Order have already been confirmed.', Status::HTTP_NOT_ACCEPTABLE);
    }elseif(strtolower($order_delivery->order->status) !== strtolower(OrderStatusEnum::DELIVERED->value)) {
      throw new Exception('Only delivered orders can be confirmed.', Status::HTTP_NOT_ACCEPTABLE);
    }
  }

  /**
   * @param OrderDelivery $order_delivery
   * @return OrderDelivery
   */
  private function confirmDeliveredOrder(OrderDelivery $order_delivery)
  {
    $order_delivery->update(['confirmation_code' => null, 'is_confirmed' => 1, 'status' => OrderDeliveryStatusEnum::CONFIRMED->value, 'payment_authorized' => 1]);
    return $order_delivery;
  }

}