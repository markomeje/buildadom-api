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
    return User::create([...$data, 'status' => 'active']);
  }
}
