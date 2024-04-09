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
    $this->command->info('Currency Seeder started.');
    $path = storage_path('currencies.json');
    $currencies = json_decode(file_get_contents($path), true);

    foreach ($currencies as $code => $name) {
      Currency::updateOrCreate(['code' => $code], [
        'type' => CurrencyTypeEnum::FIAT->value,
        'code' => $code,
        'name' => $name
      ]);
    }
    $this->command->info('Currency Seeder successful.');
  }
}
