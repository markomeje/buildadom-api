<?php

namespace Database\Seeders;
use \JsonMachine\Items;
use App\Models\City\City;
use App\Models\State\State;
use App\Models\Country\Country;
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
    $path = storage_path('globe.json');
    $countries = Items::fromFile($path);

    foreach ($countries as $country) {
      $nation = $this->seedCountry($country);
      if($nation) {
        $country_id = (int)$nation->id;

        if($country->states) {
          foreach($country->states as $state) {
            $county = $this->seedState($state, $country_id);

            if($state->cities) {
              foreach($state->cities as $city) {
                $this->seedCity($city, $county, $country_id);
              }
            }
          }
        }
      }
    }
    $this->command->info('Countries Seeder successful.');
  }

  /**
   * @param  object $country
   * @return Country
   */
  private function seedCountry(object $country)
  {
    $iso2 = strtolower($country->iso2);
    $iso3 = strtoupper($country->iso3);

    return Country::updateOrCreate(['iso2' => strtoupper($iso2), 'iso3' => $iso3], [
      'iso2' => strtoupper($iso2),
      'capital' => $country->capital,
      'iso3' => strtoupper($country->iso3),
      'name' => $country->name,
      'phone_code' => $country->phone_code,
      'region' => $country->region,
      'sub_region' => $country->subregion,
      'timezones' => $country->timezones,
      'translations' => $country->translations,
      'latitude' => $country->latitude,
      'longitude' => $country->longitude,
      'emoji' => $country->emoji,
      'flag_url' => "https://flagcdn.com/h80/{$iso2}.jpg",
    ]);
  }

  /**
   * @param object $state
   * @param int $country_id
   * @return State
   */
  private function seedState(object $state, int $country_id)
  {
    $name = $state->name;
    return State::updateOrCreate(['name' => $name, 'country_id' => $country_id], [
      'country_id' => $country_id,
      'name' => $name,
      'latitude' => $state->latitude,
      'longitude' => $state->longitude,
    ]);
  }

  /**
   * @param object $state
   * @param int $country_id
   * @param object $city
   * @return void
   */
  private function seedCity(object $city, object $state, int $country_id)
  {
    $name = $city->name;
    City::updateOrCreate(['name' => $name, 'country_id' => $country_id], [
      'country_id' => $country_id,
      'state_id' => $state->id ?? null,
      'name' => $name,
      'latitude' => $city->latitude,
      'longitude' => $city->longitude,
    ]);
  }
}
