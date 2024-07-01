<?php

namespace App\Traits\V1;
use App\Enums\Cart\CartItemStatusEnum;
use App\Models\Cart\CartItem;

trait CartItemTrait
{
  /**
   * @param array $cart_items
   * @return void
   */
  public function saveCartItems(array $cart_items, int $customer_id)
  {
    foreach ($cart_items as $item) {
      CartItem::updateOrCreate([
        'customer_id' => $customer_id,
        'product_id' => $item['product_id'],
      ],
      [
        'product_id' => $item['product_id'],
        'quantity' => $item['quantity'],
        'customer_id' => $customer_id,
        'status' => CartItemStatusEnum::PENDING->value
      ]);
    }
  }

}