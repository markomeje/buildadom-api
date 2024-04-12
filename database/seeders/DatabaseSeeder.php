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
      //CountrySeeder::class,
      CurrencySeeder::class,
      UserSeeder::class,
      DocumentTypeSeeder::class,
      ProductUnitSeeder::class,
      ProductCategorySeeder::class,
      StoreSeeder::class,
      ProductSeeder::class,
      //ProductImageSeeder::class,
    ]);
  }
}
