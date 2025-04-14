<?php

declare(strict_types=1);

namespace Database\Seeders;
use App\Enums\Currency\CurrencyTypeEnum;
use App\Models\Currency;
use Illuminate\Database\Seeder;

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
            $currency_code = strtoupper($code);
            $is_naira = $currency_code == 'NGN' ? 1 : 0;

            Currency::updateOrCreate(['code' => $currency_code], [
                'type' => CurrencyTypeEnum::FIAT->value,
                'code' => $currency_code,
                'is_default' => $is_naira,
                'name' => $name,
                'is_supported' => $is_naira,
                'symbol' => $currency_code == 'NGN' ? '₦' : null,
            ]);
        }
        $this->command->info('Currency Seeder successful.');
    }
}
