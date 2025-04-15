<?php

namespace Database\Seeders;
use App\Models\Product\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Doors and Windows',
            'Flooring',
            'Wood',
            'Plumbing and pipes',
            'Paints',
            'Roofing sheets',
            'Ceilings',
            'Electricals',
            'Tools',
            'Stairs and railings',
            'Glass and acrylics',
            'Concrete and cement products',
            'Stones and marbles',
        ];

        foreach ($categories as $category) {
            if (!ProductCategory::where('name', $category)->exists()) {
                ProductCategory::create([
                    'name' => $category,
                ]);
            }
        }
    }
}
