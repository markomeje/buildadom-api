<?php

namespace App\Traits;

use App\Enums\Cart\CartStatusEnum;
use App\Models\Cart\Cart;
use App\Models\Product\ProductImage;
use Exception;

trait CartTrait
{
  /**
   * @return null|Cart
   */
  public function createCart()
  {
    $cart = Cart::owner()->where(['status' => CartStatusEnum::PENDING->value])->first();
    if(empty($cart)) {
      $cart = Cart::create([
        'status' => CartStatusEnum::PENDING->value,
        'user_id' => auth()->id(),
      ]);
    }

    if(empty($cart)) {
      throw new Exception('Cart operation failed. Try again.');
    }

    return $cart;
  }

}