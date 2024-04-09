<?php

namespace Database\Factories;
use App\Models\Product\ProductCategory;
use App\Models\Store\Store;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    $faker = Faker::create();
    return [
      'name' => fake()->sentence(2),
      'store_id' => $faker->randomElement(Store::all()->pluck('id')->toArray()),
      'description' => fake()->text(),
      'product_category_id' => $faker->randomElement(ProductCategory::all()->pluck('id')->toArray()),
      'price' => rand(1400, 9600),
      'quantity' => rand(10, 45),
      'user_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
      'currency_id' => 1,
      'product_unit_id' => rand(3, 78),
    ];
  }
}
