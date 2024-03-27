<?php

namespace Database\Seeders;
use App\Models\Product\ProductUnit;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class ProductUnitSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $units = [
      'Kg',
      'Meters',
      'Inches',
      'Bag'
    ];

    foreach ($units as $unit) {
      if(!ProductUnit::where('name', $unit)->exists()) {
        ProductUnit::create([
          'name' => $unit,
        ]);
      }
    }
  }
}
