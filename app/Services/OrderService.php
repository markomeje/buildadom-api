<?php


namespace App\Services;
use App\Models\Order;
use App\Enums\OrderStatusEnum;


class OrderService
{

  /**
   * @param Order $order
   */
  public function __construct(public Order $order)
  {
    $this->order = $order;
  }

  /**
   * Fetch save order
   *
   * @return Order
   * @param array
   */
  public function save(float $price = 0.0): Order
  {
    $order = $this->order->where(['user_id' => auth()->id(), 'status' => OrderStatusEnum::PASSIVE->value])->first();

    $tracking_number = $this->generateUniqueTrackingNumber();
    return empty($order) ? $this->order->create(['status' => OrderStatusEnum::PASSIVE->value, 'tracking_number' => $tracking_number, 'total_amount' => $price, 'user_id' => auth()->id()]) : $order->update(['total_amount' => ($order->total_amount + $price)]);
  }

  /**
   * Generate random unique 11 digit code
   *
   * @return string
   */
  public function generateUniqueTrackingNumber(): string
  {
    do {
      $number = strtoupper(str()->random(15));
    } while ($this->order->where(['tracking_number' => $number])->first());

    return $number;
  }

  /**
   * Order details
   */
  public function details()
  {
    return $this->order->where(['user_id' => auth()->id()])->get();
  }
}












