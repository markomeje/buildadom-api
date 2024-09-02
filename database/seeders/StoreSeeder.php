<?php

namespace Database\Seeders;
use App\Models\Country;
use App\Models\Store\Store;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
    Store::truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

    foreach($this->dummyStores() as $store) {
      Store::create($store);
    }
  }

  /**
   * @return array
   */
  private function dummyStores(): array
  {
    $faker = Faker::create();
    return [
      [
        'name' => fake()->sentence(2),
        'country_id' => $faker->randomElement(Country::all()->pluck('id')->toArray()),
        'published' => 1,
        'description' => fake()->text(),
        'address' => fake()->address(),
        'user_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
      ],
      [
        'name' => fake()->sentence(2),
        'country_id' => $faker->randomElement(Country::all()->pluck('id')->toArray()),
        'published' => 1,
        'description' => fake()->text(),
        'address' => fake()->address(),
        'user_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
      ],
      [
        'name' => fake()->sentence(2),
        'country_id' => $faker->randomElement(Country::all()->pluck('id')->toArray()),
        'published' => 1,
        'description' => fake()->text(),
        'address' => fake()->address(),
        'user_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
      ],
      [
        'name' => fake()->sentence(2),
        'country_id' => $faker->randomElement(Country::all()->pluck('id')->toArray()),
        'published' => 1,
        'description' => fake()->text(),
        'address' => fake()->address(),
        'user_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
      ],
      [
        'name' => fake()->sentence(2),
        'country_id' => $faker->randomElement(Country::all()->pluck('id')->toArray()),
        'published' => 1,
        'description' => fake()->text(),
        'address' => fake()->address(),
        'user_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
      ],
      [
        'name' => fake()->sentence(2),
        'country_id' => $faker->randomElement(Country::all()->pluck('id')->toArray()),
        'published' => 1,
        'description' => fake()->text(),
        'address' => fake()->address(),
        'user_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
      ],
    ];
  }
}
