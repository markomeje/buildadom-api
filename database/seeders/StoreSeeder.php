<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Store;

class StoreSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
   public function run()
   {
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      DB::table('stores')->truncate();
      DB::statement('SET FOREIGN_KEY_CHECKS=1;');

      Store::factory()->count(520)->create();
   }
}
