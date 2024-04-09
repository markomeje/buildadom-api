<?php

namespace Database\Seeders;
use App\Models\Currency\Currency;
use App\Models\Currency\SupportedCurrency;
use Illuminate\Database\Seeder;

class SupportedCurrencySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->command->info('Supported Currency Seeder started.');
    $currencies = Currency::query()
      ->where(['code' => 'NGN'])
      ->get();

    if($currencies->count() > 0) {
      foreach ($currencies as $currency) {
        $currency_code = strtoupper($currency->code);
        SupportedCurrency::updateOrCreate(['code' => $currency_code], [
          'type' => $currency->type,
          'code' => $currency_code,
          'name' => $currency->name,
        ]);
      }
    }

    $this->command->info('Supported Currency Seeder successful.');
  }
}
