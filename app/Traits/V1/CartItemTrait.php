<?php

namespace App\Traits\V1;
use App\Enums\Cart\CartItemStatusEnum;
use App\Models\Cart\CartItem;

trait CartItemTrait
{
  /**
   * @param $item
   * @return null|CartItem
   */
  public function saveCartItem($item, int $customer_id)
  {
    $product_id = $item->product_id;
    return CartItem::updateOrCreate([
      'customer_id' => $customer_id,
      'product_id' => $product_id,
    ],
    [
      'product_id' => $product_id,
      'quantity' => $item->quantity,
      'customer_id' => $customer_id,
      'status' => CartItemStatusEnum::PENDING->value
    ]);
  }

}