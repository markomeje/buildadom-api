<?php

namespace Database\Seeders;
use \JsonMachine\Items;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $path = storage_path('/globe.json');
    $countries = Items::fromFile($path);

    foreach ($countries as $country) {
      Country::create([
        'currency' => $country->currency,
        'iso2' => $country->iso2, 
        'capital' => $country->capital, 
        'iso3' => $country->iso3, 
        'name' => $country->name, 
        'phone_code' => $country->phone_code, 
        'region' => $country->region, 
      ]);  
    }
  }
}
