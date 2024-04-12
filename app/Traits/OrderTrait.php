<?php

namespace App\Traits;
use App\Enums\Cart\CartItemStatusEnum;
use App\Enums\Order\OrderStatusEnum;
use App\Models\Cart\CartItem;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\Product\Product;
use Exception;

trait OrderTrait
{
  /**
   * @return string
   */
  public function generateTrackingNumber(): string
  {
    do {
      $tracking_number = strtoupper(str()->random(15));
    } while (Order::where('tracking_number', $tracking_number)->exists());
    return $tracking_number;
  }

  /**
   * @param CartItem $item
   * @return void
   */
  public function createOrder(CartItem $item)
  {
    $product = $item->product;
    if(empty($product)) {
      throw new Exception('Invalid cart product');
    }

    $quantity = empty($item->quantity) ? 1 : $item->quantity;
    $price = (float)$product->price;
    $total_amount = (float)($price * $quantity);
    $user_id = auth()->id();

    $product_id = $item->product_id;
    $order = Order::updateOrCreate([
      'product_id' => $product_id,
      'status' => OrderStatusEnum::PENDING->value,
      'user_id' => $user_id
    ], [
      'total_amount' => $total_amount,
      'product_id' => $product_id,
      'status' => OrderStatusEnum::PENDING->value,
      'user_id' => $user_id,
      'store_id' => $product->store_id,
      'currency_id' => $product->currency_id,
      'tracking_number' => $this->generateTrackingNumber(),
      'quantity' => $quantity,
      'amount' => $price,
    ]);

    $item->update(['status' => CartItemStatusEnum::PROCESSING->value]);
  }

}