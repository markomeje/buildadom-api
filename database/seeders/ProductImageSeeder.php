<?php

declare(strict_types=1);

namespace Database\Seeders;
use App\Models\Product\Product;
use App\Models\Product\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductImage::factory()->count(Product::count() * 4)->create();
    }
}
