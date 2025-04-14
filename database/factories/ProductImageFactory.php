<?php

declare(strict_types=1);

namespace Database\Factories;
use App\Enums\Product\ProductImageRoleEnum;
use App\Models\Product\Product;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create();
        $faker->addProvider(new \Smknstd\FakerPicsumImages\FakerPicsumImagesProvider($faker));

        return [
            'product_id' => $faker->randomElement(Product::all()->pluck('id')->toArray()),
            'role' => $faker->randomElement(ProductImageRoleEnum::array()),
            'user_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        ];
    }
}
