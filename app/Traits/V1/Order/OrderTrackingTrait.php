<?php

namespace App\Traits\V1\Order;
use App\Enums\Order\OrderFulfillmentStatusEnum;
use App\Enums\Order\OrderStatusEnum;
use App\Models\Order\Order;
use App\Models\Order\OrderFulfillment;
use App\Utility\Status;
use Exception;

trait OrderTrackingTrait
{

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
      $current_status = OrderStatusEnum::FULFILLED->value;
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
    if($current_status == strtolower(OrderStatusEnum::DECLINED->value)) {
      throw new Exception('Order has already been declined.', Status::HTTP_NOT_ACCEPTABLE);
    }elseif($current_status == strtolower(OrderStatusEnum::PLACED->value)) {
      throw new Exception('You need to accept or decline the order first.', Status::HTTP_NOT_ACCEPTABLE);
    }
  }

}