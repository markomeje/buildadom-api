<?php

namespace Database\Seeders;
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

    $this->call([
      CountrySeeder::class,
      CategorySeeder::class,
      CurrencySeeder::class,
      DocumentTypeSeeder::class,
      // UnitSeeder::class,
    ]);
  }
}
