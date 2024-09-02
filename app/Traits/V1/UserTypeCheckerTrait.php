<?php

namespace App\Traits\V1;
use App\Enums\User\UserTypeEnum;
use App\Models\User;


trait UserTypeCheckerTrait
{
  /**
   * Checks if the user has a businnes profile
   *
   * @return bool
   */
  public static function isBusinnesProfile(User $user): bool
  {
    $business = strtolower(UserTypeEnum::BUSINESS->value);
    return strtolower($user->type) === $business;
  }

  /**
   * Checks if the user account is an individual account
   *
   * @return bool
   */
  public function isIndividualProfile(User $user): bool
  {
    $individual = strtolower(UserTypeEnum::INDIVIDUAL->value);
    return strtolower($user->type) === $individual;
  }
}
