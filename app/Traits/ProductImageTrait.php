<?php

namespace App\Traits;
use App\Enums\Product\ProductImageRoleEnum;
use App\Models\Product\ProductImage;

trait ProductImageTrait
{
  /**
   * @param int $product_id
   * @return bool
   */
  public function productHasMainImage(int $product_id): bool
  {
    return ProductImage::owner()->where(['role' => ProductImageRoleEnum::MAIN->value, 'product_id' => $product_id])->exists();
  }

}