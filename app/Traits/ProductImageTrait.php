<?php

declare(strict_types=1);

namespace App\Traits;
use App\Enums\Product\ProductImageRoleEnum;
use App\Models\Product\ProductImage;

trait ProductImageTrait
{
    /**
     * @return bool
     */
    public function productHasMainImage(int $product_id)
    {
        return ProductImage::owner()->where(['role' => strtolower(ProductImageRoleEnum::MAIN->value), 'product_id' => $product_id])->exists();
    }
}
