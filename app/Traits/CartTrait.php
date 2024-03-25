<?php

namespace App\Traits;

use App\Enums\Cart\CartStatusEnum;
use App\Models\Cart\Cart;
use App\Models\Product\ProductImage;

trait CartTrait
{
  /**
   * @return null|Cart
   */
  public function isPendingCart()
  {
    return Cart::owner()->where(['status' => CartStatusEnum::PENDING->value])->first();
  }

}