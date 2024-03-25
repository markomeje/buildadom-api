<?php

namespace Database\Seeders;
use App\Enums\Country\SupportedCountryStatusEnum;
use App\Models\Country\Country;
use App\Models\Country\SupportedCountry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupportedCountrySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
    DB::table('supported_countries')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

    $countries = Country::select('id', 'iso2')
      ->where(['iso2' => 'NG'])
      ->orWhere(['iso2' => 'US'])
      ->orWhere(['iso2' => 'GB'])
      ->orWhere(['iso2' => 'ZA'])
      ->orWhere(['iso2' => 'GH'])
      ->get();

    if($countries->count() > 0) {
      foreach ($countries as $country) {
        $country_id = $country->id;
        SupportedCountry::updateOrCreate(['country_id' => $country_id], [
          'country_id' => $country_id,
          'status' => SupportedCountryStatusEnum::ACTIVE->value,
        ]);
      }
    }
  }
}
