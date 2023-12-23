<?php

namespace App\Actions\V1\User;
use Hash;
use App\Models\V1\User\User;
use App\Enums\V1\User\UserStatusEnum;
use Propaganistas\LaravelPhone\PhoneNumber;


class CreateUserAction
{
  /**
   * Handle User request
   *
   * @return ?User
   */
  public static function handle(array $data): ?User
  {
    $data['phone'] = (string)(new PhoneNumber($data['phone']));
    $data['password'] = Hash::make($data['password']);
    return User::create([
      ...$data,
      'status' => UserStatusEnum::PENDING->value
    ]);
  }
}
