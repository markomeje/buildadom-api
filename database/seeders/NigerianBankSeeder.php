<?php

namespace Database\Seeders;
use \JsonMachine\Items;
use App\Models\Bank\NigerianBank;
use Illuminate\Database\Seeder;

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

    if(!empty($banks)) {
      foreach ($banks as $bank) {
        if(is_object($bank)) {
          $this->seedNigerianBank($bank);
        }
      }
    }

    $this->command->info('Nigerain Banks Seeder successful.');
  }

  /**
   * @param  object $bank
   * @return void
   */
  private function seedNigerianBank(object $bank)
  {
    $bank_code = $bank->bank_code;
    NigerianBank::updateOrCreate(['bank_code' => $bank->bank_code], [
      'bank_name' => ucwords(strtolower($bank->bank_name)),
      'bank_code' => $bank_code,
      'is_active' => 1,
    ]);
  }
}
