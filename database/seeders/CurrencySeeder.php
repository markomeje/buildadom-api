<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('currencies')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    $currencies = [
      ['code' =>'NGN' , 'name' => 'Naira', 'symbol' => '₦'],
    ];

    foreach ($currencies as $currency) {
      Currency::create($currency);
    }
  }
}
