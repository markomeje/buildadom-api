<?php

namespace Database\Seeders;

use App\Enums\User\UserRoleEnum;
use App\Enums\User\UserStatusEnum;
use App\Enums\User\UserTypeEnum;
use App\Models\User;
use App\Models\UserRole;
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
      ['firstname' => 'Elim', 'lastname' => 'Bolt', 'email' => 'jelan@gmail.com', 'password' => Hash::make('12345'), 'phone' => '090489987671', 'status' => UserStatusEnum::ACTIVE->value, 'address' => 'No 43 Main road, Oakland Inn.', 'type' => UserTypeEnum::BUSINESS->value],
      ['firstname' => 'Admin', 'lastname' => 'Boss', 'email' => 'admin@gmail.com', 'password' => Hash::make('admin'), 'phone' => '09145987671', 'status' => UserStatusEnum::ACTIVE->value, 'address' => 'No 43 Main road, Oakland Inn.', 'type' => UserTypeEnum::INDIVIDUAL->value],
    ];

    foreach($users as $user) {
      $user = User::updateOrCreate(['email' => $user['email']], $user);
      if($user) {
        $user_id = $user['id'];
        UserRole::updateOrCreate(['user_id' => $user_id], [
          'user_id' => $user_id,
          'name' => UserRoleEnum::ADMIN->value
        ]);
      }
    }
  }
}
