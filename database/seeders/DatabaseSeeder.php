<?php

namespace Database\Seeders;
use App\Models\{User, Product, Store, Country};
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {

    User::factory(20)->create()->each(function($user) {
      Store::create([
        'name' => fake()->sentence(2),
        'country_id' => rand(1, Country::count()),
        'city' => fake()->city(),
        'description' => fake()->text(),
        'address' => fake()->address(),
        'active' => true,
        'user_id' => $user->id,
      ]);
    });

    //$this->call([
      //UserSeeder::class,
      //CountrySeeder::class,
      //CategorySeeder::class,
      //StoreSeeder::class,
    //   ProductSeeder::class,
    // ]);
  }
}
