<?php

namespace App\Actions;
use App\Models\User;
use Propaganistas\LaravelPhone\PhoneNumber;
use Hash;


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
    return $user;
  }
}
