<?php

namespace Database\Seeders;
use App\Models\Product\ProductUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        ProductUnit::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        $units = [
            'kg',
            'meter',
            'inch',
            'bag',
            'sqft',
        ];

        if (!empty($units)) {
            collect($units)->map(function ($unit) {
                ProductUnit::updateOrCreate(['name' => $unit], [
                    'name' => strtolower($unit),
                ]);
            });
        }

    }
}
