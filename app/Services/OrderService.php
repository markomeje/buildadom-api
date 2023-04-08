<?php


namespace App\Services;
use App\Models\Order;


class OrderService
{
  /**
   * Save Order data
   *
   * @return Order
   * @param array
   */
  public function save(array $data): Order
  {
    $order = self::information();
    if(empty($order)) {
      return Order::create([
        'user_id' => auth()->id(),
        ...$data,
      ]);
    }

    $order->update([...$data]);
    return $order;
  }

  /**
   * Order details
   */
  public static function information()
  {
    return Order::where(['user_id' => auth()->id()])->first();
  }
}












