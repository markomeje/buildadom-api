<?php

namespace Database\Seeders;
use App\Enums\Fee\FeesEnum;
use App\Enums\Fee\FeeTypeEnum;
use App\Models\Fee\FeeSetting;
use App\Traits\V1\CurrencyTrait;
use App\Traits\V1\Fee\FeeSettingTrait;
use Illuminate\Database\Seeder;


class FeesSeeder extends Seeder
{
  use FeeSettingTrait, CurrencyTrait;

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->command->info('Fees Seeder started.');
    $fees = FeesEnum::array();

    foreach ($fees as $code) {
      FeeSetting::updateOrCreate([
        'code' => $code,
      ], [
        'code' => $code,
        'currency_id' => $this->getDefaultCurrency()->id,
        'type' => FeeTypeEnum::FLAT_FEE->value,
        'description' => $this->convertToReadable($code),
        'amount' => 1.00
      ]);
    }

    $this->command->info('Fees Seeder successful.');
  }
}
