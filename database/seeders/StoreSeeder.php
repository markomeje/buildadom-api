<?php

declare(strict_types=1);

namespace Database\Seeders;
use App\Enums\User\UserRoleEnum;
use App\Models\Country;
use App\Models\Store\Store;
use App\Models\UserRole;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        Store::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        $stores = $this->dummyStores();
        if (!empty($stores) && is_array($stores)) {
            foreach ($stores as $store) {
                Store::create($store);
            }
        }
    }

    private function dummyStores(): array
    {
        $faker = Faker::create();

        return [
            [
                'name' => fake()->sentence(2),
                'country_id' => $faker->randomElement(Country::all()->pluck('id')->toArray()),
                'published' => 1,
                'description' => fake()->text(),
                'address' => fake()->address(),
                'user_id' => $faker->randomElement(UserRole::where('name', UserRoleEnum::MERCHANT->value)->pluck('user_id')->toArray()),
            ],
            [
                'name' => fake()->sentence(2),
                'country_id' => $faker->randomElement(Country::all()->pluck('id')->toArray()),
                'published' => 1,
                'description' => fake()->text(),
                'address' => fake()->address(),
                'user_id' => $faker->randomElement(UserRole::where('name', UserRoleEnum::MERCHANT->value)->pluck('user_id')->toArray()),
            ],
            [
                'name' => fake()->sentence(2),
                'country_id' => $faker->randomElement(Country::all()->pluck('id')->toArray()),
                'published' => 1,
                'description' => fake()->text(),
                'address' => fake()->address(),
                'user_id' => $faker->randomElement(UserRole::where('name', UserRoleEnum::MERCHANT->value)->pluck('user_id')->toArray()),
            ],
            [
                'name' => fake()->sentence(2),
                'country_id' => $faker->randomElement(Country::all()->pluck('id')->toArray()),
                'published' => 1,
                'description' => fake()->text(),
                'address' => fake()->address(),
                'user_id' => $faker->randomElement(UserRole::where('name', UserRoleEnum::MERCHANT->value)->pluck('user_id')->toArray()),
            ],
            [
                'name' => fake()->sentence(2),
                'country_id' => $faker->randomElement(Country::all()->pluck('id')->toArray()),
                'published' => 1,
                'description' => fake()->text(),
                'address' => fake()->address(),
                'user_id' => $faker->randomElement(UserRole::where('name', UserRoleEnum::MERCHANT->value)->pluck('user_id')->toArray()),
            ],
            [
                'name' => fake()->sentence(2),
                'country_id' => $faker->randomElement(Country::all()->pluck('id')->toArray()),
                'published' => 1,
                'description' => fake()->text(),
                'address' => fake()->address(),
                'user_id' => $faker->randomElement(UserRole::where('name', UserRoleEnum::MERCHANT->value)->pluck('user_id')->toArray()),
            ],
        ];
    }
}
