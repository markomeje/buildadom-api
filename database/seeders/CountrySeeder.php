<?php

namespace Database\Seeders;
use \JsonMachine\Items;
use App\Models\City\City;
use App\Models\State\State;
use App\Models\Country\Country;
use Illuminate\Database\Seeder;
use App\Models\Currency\Currency;
use Illuminate\Support\Facades\DB;
use App\Enums\State\StateStatusEnum;
use App\Enums\Currency\CurrencyTypeEnum;
use App\Enums\Currency\CurrencyStatusEnum;

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
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('cities')->truncate();
    DB::table('states')->truncate();
    DB::table('currencies')->truncate();
    DB::table('countries')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    $countries_path = storage_path('globe.json');
    $countries = Items::fromFile($countries_path);

    $currencies_path = storage_path('currencies.json');
    $currencies = json_decode(file_get_contents($currencies_path), true);

    foreach ($countries as $country) {
      $nation = $this->seedCountry($country);
      if($nation) {
        $country_id = (int)$nation->id;
        $this->seedCurrency($country, $country_id, $currencies);

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
    $this->command->info('Country Seeder completed successfully.');
  }

  /**
   * @param  object $country
   * @return Country
   */
  private function seedCountry(object $country)
  {
    $iso2 = strtolower($country->iso2);
    return Country::create([
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
    return State::create([
      'country_id' => $country_id,
      'name' => $state->name,
      'status' => StateStatusEnum::ACTIVE->value,
      'latitude' => $state->latitude,
      'longitude' => $state->longitude,
    ]);
  }

  /**
   * @param object $country
   * @param int $country_id
   * @param array $currencies
   * @return void
   */
  private function seedCurrency(object $country, int $country_id, array $currencies)
  {
    $currency_code = strtoupper($country->currency);
    Currency::updateOrCreate(['code' => $currency_code], [
      'country_id' => $country_id,
      'type' => CurrencyTypeEnum::FIAT->value,
      'status' => CurrencyStatusEnum::ACTIVE->value,
      'code' => $currency_code,
      'name' => $currencies[$currency_code] ?? ''
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
    City::create([
      'country_id' => $country_id,
      'state_id' => $state->id ?? null,
      'name' => $city->name,
      'status' => StateStatusEnum::ACTIVE->value,
      'latitude' => $city->latitude,
      'longitude' => $city->longitude,
    ]);
  }
}
