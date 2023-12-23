<?php

namespace App\Traits\V1\User;
use App\Models\User;
use App\Enums\User\UserTypeEnum;


trait UserTrait
{
  /**
   * Checks if the user has a businnes profile
   *
   * @return bool
   */
  public static function isBusinnesUser(User $user): bool
  {
    $business = strtolower(UserTypeEnum::BUSINESS->value);
    return strtolower($user->type) === $business;
  }

  /**
   * Checks if the user account is an individual account
   *
   * @return bool
   */
  public function isIndividualUser(User $user): bool
  {
    $individual = strtolower(UserTypeEnum::INDIVIDUAL->value);
    return strtolower($user->type) === $individual;
  }
}
