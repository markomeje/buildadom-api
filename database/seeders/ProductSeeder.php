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
    DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
    Product::truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

    foreach($this->dummyProducts() as $product) {
      Product::create($product);
    }
  }

  private function dummyProducts()
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
