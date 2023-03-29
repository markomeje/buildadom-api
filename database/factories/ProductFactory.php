<?php

namespace Database\Factories;
use App\Models\{Store, User, Country, Category};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'name' => fake()->sentence(2),
      'store_id' => rand(1, Store::count()),
      'description' => fake()->text(),
      'category_id' => rand(1, Category::count()),
      'price' => rand(1400, 9600),
      'quantity' => rand(10, 45),
      'status' => 'active',
      'user_id' => rand(1, User::count()),
      'attributes' => implode('|', [fake()->word(), fake()->word(), fake()->word()])
    ];
  }
}
