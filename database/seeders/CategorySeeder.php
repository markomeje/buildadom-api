<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('categories')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

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
      Category::create([
        'name' => strtolower($category),
        'type' => 'product' 
      ]);  
    }
  }
}
