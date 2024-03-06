<?php

namespace Database\Seeders;
use App\Enums\Currency\CurrencyTypeEnum;
use App\Models\Currency\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
      ['code' => 'NGN' , 'name' => 'Nigerian Naira', 'symbol' => '₦', 'type' => CurrencyTypeEnum::FIAT->value],
      ['code' => 'USD' , 'name' => 'US Dollar', 'symbol' => '$', 'type' => CurrencyTypeEnum::FIAT->value],
    ];

    foreach ($currencies as $currency) {
      Currency::updateOrCreate(
        ['code' => $currency['code']],
        $currency
      );
    }
  }
}
