<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Image;

class ImageSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    //DB::table('products')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    Image::factory()->count(3490)->create();
  }
}
