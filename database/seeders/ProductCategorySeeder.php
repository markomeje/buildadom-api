<?php

namespace Database\Seeders;
use App\Models\Product\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
    DB::table('product_categories')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

    $categories = [
      'Doors and Windows',
      'Flooring',
      'Wood',
      'Plumbing and pipes',
      'Paints',
      'Roofing sheets',
      'Ceilings',
      'Electricals',
      'Tools',
      'Stairs and railings',
      'Glass and acrylics',
      'Concrete and cement products',
      'Stones and marbles',
    ];

    foreach ($categories as $category) {
      ProductCategory::create([
        'name' => $category,
      ]);
    }
  }
}
