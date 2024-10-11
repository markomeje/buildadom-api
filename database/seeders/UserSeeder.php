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
      ['firstname' => 'Elim', 'lastname' => 'Bolt', 'email' => 'markomejeonline@gmail.com', 'password' => Hash::make('12345'), 'phone' => '08158212666', 'status' => UserStatusEnum::ACTIVE->value, 'address' => 'No 43 Main road, Oakland Inn.', 'type' => UserTypeEnum::BUSINESS->value, 'role' => UserRoleEnum::MERCHANT->value],

      ['firstname' => 'Admin', 'lastname' => 'Access', 'email' => 'admin@gmail.com', 'password' => Hash::make('admin'), 'phone' => '08097654009', 'status' => UserStatusEnum::ACTIVE->value, 'address' => 'No 43 Main road, Oakland Inn.', 'type' => UserTypeEnum::BUSINESS->value, 'role' => UserRoleEnum::ADMIN->value],
    ];

    foreach($users as $user) {
      $seed_user = User::updateOrCreate([
        'email' => $user['email']
      ],[
        'email' => $user['email'],
        'firstname' => $user['firstname'],
        'lastname' => $user['lastname'],
        'password' => $user['password'],
        'phone' => $user['phone'],
        'status' => $user['status'],
        'address' => $user['address'],
        'type' => $user['type'],
        ]
    );

    if($seed_user) {
      $user_id = $seed_user->id;
      UserRole::updateOrCreate(['user_id' => $user_id], [
        'user_id' => $user_id,
        'name' => $user['role']
      ]);
    }
    }
  }
}
