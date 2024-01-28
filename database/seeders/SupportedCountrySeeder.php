<?php

namespace Database\Seeders;
use App\Models\Country\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Country\SupportedCountry;

class SupportedCountrySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('supported_countries')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    $countries = Country::select('id')
      ->where(['iso2' => 'NG'])
      ->orWhere(['iso2' => 'US'])
      ->orWhere(['iso2' => 'UK'])
      ->orWhere(['iso2' => 'GH'])
      ->get();

    if(count($countries)) {
      foreach ($countries as $country) {
        SupportedCountry::create([
          'country_id' => $country->id
        ]);
      }
    }

  }
}
