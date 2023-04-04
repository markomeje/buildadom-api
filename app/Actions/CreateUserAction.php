<?php

namespace App\Actions;
use App\Models\{User, Role};
use Propaganistas\LaravelPhone\PhoneNumber;
use Hash;
use Exception;


class CreateUserAction
{
  /**
   * Handle User request
   *
   * @return User model
   */
  public static function handle(array $data): User
  {
    $data['phone'] = (string)(new PhoneNumber($data['phone']));
    $data['password'] = Hash::make($data['password']);
    $user = User::create([...$data, 'status' => 'active']);

    if(empty($user)) throw new Exception('Unknown error. Please try again.');
    Role::create(['user_id' => $user->id, 'name' => 'marchant']);
    return $user;
  }
}
