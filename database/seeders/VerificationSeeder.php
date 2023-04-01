<?php

namespace Database\Seeders;
use \JsonMachine\Items;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\{Verification, User};
use Hash;

class VerificationSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $user = User::create([
      'email' => 'markomejeonline@gmail.com',
      'phone' => '08158212666',
      'password' => Hash::make('123456'),
      'type' => 'individual',
      'firstname' => fake()->firstName(),
      'lastname' => fake()->lastName(),
    ]);

    if (!empty($user)) {
      foreach (['email', 'phone'] as $type) {
        Verification::create([
          'verified' => true,
          'code' => null,
          'expiry' => null,
          'user_id' => $user->id,
          'type' => $type
        ]);
      }
    }
  }
}
