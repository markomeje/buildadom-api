<?php

namespace Database\Seeders;
use App\Models\Product\ProductUnit;
use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductUnitSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
    DB::table('product_units')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

    $units = [
      'Kg',
      'Meters',
      'Inches',
      'Bag'
    ];

    foreach ($units as $unit) {
      ProductUnit::create([
        'name' => $unit,
      ]);
    }
  }
}
