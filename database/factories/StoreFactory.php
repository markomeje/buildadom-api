<?php

namespace Database\Factories;
use App\Models\Country;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = Faker::create();

        return [
            'name' => fake()->sentence(2),
            'country_id' => $faker->randomElement(Country::all()->pluck('id')->toArray()),
            'city' => fake()->city(),
            'description' => fake()->text(),
            'address' => fake()->address(),
            'user_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        ];
    }
}
