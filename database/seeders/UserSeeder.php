<?php

namespace Database\Seeders;

use App\Enums\User\UserStatusEnum;
use App\Enums\User\UserTypeEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $users = [
      ['firstname' => 'Elim', 'lastname' => 'Bolt', 'email' => 'jelan@gmail.com', 'password' => Hash::make('12345'), 'phone' => '09098987671', 'status' => UserStatusEnum::ACTIVE->value, 'address' => 'No 43 Main road, Oakland Inn.', 'type' => UserTypeEnum::BUSINESS->value]
    ];

    foreach($users as $user) {
      User::updateOrCreate(['email' => $user['email']], $user);
    }
  }
}
