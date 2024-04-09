<?php

namespace Database\Seeders;
use App\Models\Store\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Store::factory()->count(108)->create();
  }
}
