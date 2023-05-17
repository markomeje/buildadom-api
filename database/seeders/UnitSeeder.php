<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('units')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    $units = [
      'Kg',
      'Meters',
      'Inches',
    ];

    foreach ($units as $unit) {
      Unit::create([
        'name' => strtolower($unit),
        'description' => null
      ]);
    }
  }
}
