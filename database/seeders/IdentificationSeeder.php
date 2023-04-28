<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Identification;

class IdentificationSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('identifications')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    Identification::factory()->count(345)->create();
  }
}
