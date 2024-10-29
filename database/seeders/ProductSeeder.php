<?php

namespace Database\Seeders;
use App\Models\Product\Product;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductUnit;
use App\Models\Store\Store;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $products = $this->getDummyProducts();
    if(!empty($products) && is_array($products)) {
      foreach($products as $product) {
        Product::updateOrCreate(['name' => $product['name']], [...$product, 'published' => 1]);
      }
    }
  }

  /**
   * @return array
   */
  private function getDummyProducts(): array
  {
    $faker = Faker::create();
    return [
      [
        'name' => fake()->sentence(2),
        'store_id' => $faker->randomElement(Store::all()->pluck('id')->toArray()),
        'description' => fake()->text(),
        'product_category_id' => $faker->randomElement(ProductCategory::all()->pluck('id')->toArray()),
        'price' => rand(1400, 9600),
        'quantity' => rand(10, 45),
        'user_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'currency_id' => 1,
        'product_unit_id' => rand(1, ProductUnit::count()),
      ],
      [
        'name' => fake()->sentence(2),
        'store_id' => $faker->randomElement(Store::all()->pluck('id')->toArray()),
        'description' => fake()->text(),
        'product_category_id' => $faker->randomElement(ProductCategory::all()->pluck('id')->toArray()),
        'price' => rand(1400, 9600),
        'quantity' => rand(10, 45),
        'user_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'currency_id' => 1,
        'product_unit_id' => rand(1, ProductUnit::count()),
      ],
      [
        'name' => fake()->sentence(2),
        'store_id' => $faker->randomElement(Store::all()->pluck('id')->toArray()),
        'description' => fake()->text(),
        'product_category_id' => $faker->randomElement(ProductCategory::all()->pluck('id')->toArray()),
        'price' => rand(1400, 9600),
        'quantity' => rand(10, 45),
        'user_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'currency_id' => 1,
        'product_unit_id' => rand(1, ProductUnit::count()),
      ],
      [
        'name' => fake()->sentence(2),
        'store_id' => $faker->randomElement(Store::all()->pluck('id')->toArray()),
        'description' => fake()->text(),
        'product_category_id' => $faker->randomElement(ProductCategory::all()->pluck('id')->toArray()),
        'price' => rand(1400, 9600),
        'quantity' => rand(10, 45),
        'user_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'currency_id' => 1,
        'product_unit_id' => rand(1, ProductUnit::count()),
      ],
    ];
  }
}
