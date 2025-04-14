<?php

declare(strict_types=1);

namespace Database\Seeders;
use App\Models\City\City;
use App\Models\Country;
use App\Models\State\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use JsonMachine\Items;

class CountrySeeder extends Seeder
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        Country::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        $this->command->info('Country Seeder started.');
        $path = storage_path('globe.json');
        $countries = Items::fromFile($path);

        if (!empty($countries)) {
            foreach ($countries as $country) {
                $currency = strtoupper($country->currency ?? '');
                if ($currency == 'NGN' || $currency == 'GHS') {
                    $this->runSeeder($country);
                }
            }
        }

        $this->command->info('Country Seeder completed.');
    }

    /**
     * @param  mixed  $countries
     * @return void
     */
    private function runSeeder($country)
    {
        $nation = $this->seedCountry($country);
        if ($nation) {
            $country_id = (int) $nation->id;
            if ($country->states) {
                foreach ($country->states as $state) {
                    $county = $this->seedState($state, $country_id);

                    if ($state->cities) {
                        foreach ($state->cities as $city) {
                            $this->seedCity($city, $county, $country_id);
                        }
                    }
                }
            }
        }
    }

    /**
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
            'is_supported' => $iso2 == 'ng' ? 1 : 0,
        ]);
    }

    /**
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
