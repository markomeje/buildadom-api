<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CurrencySeeder::class,
            FeesSeeder::class,
            UserSeeder::class,
            DocumentTypeSeeder::class,
            ProductUnitSeeder::class,
            ProductCategorySeeder::class,
            NigerianBankSeeder::class,
            UserSeeder::class,
            CountrySeeder::class,
        ]);
    }
}
