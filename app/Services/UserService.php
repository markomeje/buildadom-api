<?php


namespace App\Services;
use App\Models\{User, Country};
use Propaganistas\LaravelPhone\PhoneNumber;
use \Exception;


class UserService
{
  /**
   * Create User
   *
   * @param array $data
   */
  public function create(array $data): User
  {
    return User::create([
      ...$data,
      'phone' => (string)(new PhoneNumber($data['phone'])),
      'password' => Hash::make($data['password'])
    ]);
  }
