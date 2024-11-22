<?php

namespace App\Traits\V1\Order;
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

  /**
   * @param OrderFulfillment $order_fulfillment
   * @throws Exception
   * @return void
   */
  public function handleFulfilledOrderConfirmationChecks(OrderFulfillment $order_fulfillment)
  {
    if(empty($order_fulfillment)) {
      throw new Exception('Order fulfillment record not found.', Status::HTTP_NOT_FOUND);
    }elseif($order_fulfillment->is_confirmed) {
      throw new Exception('Order have already been confirmed.', Status::HTTP_NOT_ACCEPTABLE);
    }elseif(strtolower($order_fulfillment->order->status) !== strtolower(OrderStatusEnum::FULFILLED->value)) {
      throw new Exception('Only fulfilled orders can be confirmed.', Status::HTTP_NOT_ACCEPTABLE);
    }
  }

  /**
   * @param OrderFulfillment $order_fulfillment
   * @return OrderFulfillment
   */
  private function confirmFulfilledOrder(OrderFulfillment $order_fulfillment)
  {
    $order_fulfillment->update(['confirmation_code' => null, 'is_confirmed' => 1, 'confirmed_at' => Carbon::now(), 'status' => strtolower(OrderFulfillmentStatusEnum::CONFIRMED->value), 'payment_authorized' => 1]);
    return $order_fulfillment;
  }

}