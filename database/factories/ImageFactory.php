<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Image, User, Product};
use Faker\Factory as Faker;

class ImageFactory extends Factory
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
      'model' => $faker->randomElement(['store', 'product']),
      'url' => $faker->imageUrl($width = 1260, $height = 960),
      'model_id' => rand(1, Product::count()),
      'role' => $faker->randomElement(['main', 'cover', 'others']),
      'user_id' => null,
    ];
  }
}
