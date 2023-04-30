<?php

namespace Database\Factories;
use App\Models\{Store, User, Country, Category};
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

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
    $faker = Faker::create();
    return [
      'name' => fake()->sentence(2),
      'store_id' => $faker->randomElement(Store::all()->pluck('id')->toArray()),
      'description' => fake()->text(),
      'category_id' => $faker->randomElement(Category::all()->pluck('id')->toArray()),
      'price' => rand(1400, 9600),
      'quantity' => rand(10, 45),
      'status' => 'active',
      'user_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
      'attributes' => null,
      'currency_id' => 1,
    ];
  }
}
