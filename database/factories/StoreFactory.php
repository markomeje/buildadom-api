<?php

namespace Database\Factories;
use App\Models\{Country, User};
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class StoreFactory extends Factory
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
      'country_id' => rand(1, Country::count()),
      'city' => fake()->city(),
      'description' => fake()->text(),
      'address' => fake()->address(),
      'active' => true,
      'user_id' => rand(2, User::count()),
    ];
  }
}
