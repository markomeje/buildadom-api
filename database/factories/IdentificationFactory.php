<?php

namespace Database\Factories;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{User, Country, Identification};
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Identification>
 */
class IdentificationFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    $faker = Faker::create();
    $type = $faker->randomElement(['individual', 'business']);
    return [
      'id_type' => $faker->randomElement(Identification::$types),
      'fullname' => $type === 'business' ? $faker->name() : null,
      'id_number' => $faker->numberBetween(1000000, 2000000),
      'citizenship_country' => $faker->randomElement(Country::all()->pluck('id')->toArray()),
      'expiry_date' => Carbon::yesterday()->subDays(98)->addYears(rand(3, 9)),
      'state' => $faker->state(),
      'dob' => Carbon::now()->subWeeks(7)->subYears(rand(23, 56)),
      'birth_country' => $faker->randomElement(Country::all()->pluck('id')->toArray()),
      'type' => $type,
      'user_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
      'address' => $faker->address(),
      'verified' => false,
    ];
  }
}
