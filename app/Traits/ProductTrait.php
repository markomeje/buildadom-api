<?php

namespace App\Traits;
use App\Enums\Product\ProductImageRoleEnum;
use App\Models\Product\ProductImage;

trait ProductTrait
{
  /**
   * @param array $relations
   * @return array
   */
  public function loadProductRelations($with = []): array
  {
    return [
      'unit' => fn($query) => $query->select(['id', 'name']),
      'images' => fn($query) => $query->select(['id', 'url']),
      'category' => fn($query) => $query->select(['id', 'name']),
      'store' => fn($query) => $query->select(['id', 'name', 'description', 'banner', 'logo', 'address']),
      'currency' => fn($query) => $query->select(['id', 'name', 'code']),
    ];
  }

}