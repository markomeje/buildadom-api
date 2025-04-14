<?php

declare(strict_types=1);

namespace Database\Seeders;
use App\Models\Bank\NigerianBank;
use Illuminate\Database\Seeder;
use JsonMachine\Items;

class NigerianBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Nigerain Banks Seeder started.');
        $path = storage_path('banks.json');
        $banks = Items::fromFile($path);

        if (!empty($banks)) {
            foreach ($banks as $bank) {
                if (is_object($bank)) {
                    $this->seedNigerianBank((object) $bank);
                }
            }
        }

        $this->command->info('Nigerain Banks Seeder successful.');
    }

    /**
     * @return void
     */
    private function seedNigerianBank(object $bank)
    {
        $bank_code = $bank->code;
        NigerianBank::updateOrCreate([
            'code' => $bank_code,
        ], [
            'name' => $bank->name,
            'code' => $bank_code,
            'slug' => $bank->slug,
            'ussd' => $bank->ussd,
            'is_active' => 1,
        ]);
    }
}
