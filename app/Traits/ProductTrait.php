<?php

namespace App\Traits;
use App\Enums\Product\ProductImageRoleEnum;
use App\Models\Product\ProductImage;

trait ProductTrait
{
  /**
   * @return array
   */
  public function loadProductRelations(): array
  {
    return [
      'unit' => fn($query) => $query->select(['id', 'name']),
      'images' => fn($query) => $query->select(['id', 'url', 'role', 'product_id']),
      'category' => fn($query) => $query->select(['id', 'name']),
      'store' => fn($query) => $query->select(['id', 'name', 'description', 'banner', 'logo', 'address']),
      'currency' => fn($query) => $query->select(['id', 'name', 'code']),
    ];
  }

}