<?php

namespace Database\Seeders;
use App\Jobs\SeedCountryListJob;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->command->info('Country Seeder started.');
    SeedCountryListJob::dispatch();
    $this->command->info('Country Seeder queued.');
  }

}
