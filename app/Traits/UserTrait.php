<?php

declare(strict_types=1);

namespace App\Traits;
use App\Enums\User\UserTypeEnum;
use App\Models\User;

trait UserTrait
{
    /**
     * Checks if the user has a businnes profile
     */
    public static function isBusinnesUser(User $user): bool
    {
        $business = strtolower(UserTypeEnum::BUSINESS->value);

        return strtolower($user->type) === $business;
    }

    /**
     * Checks if the user account is an individual account
     */
    public function isIndividualUser(User $user): bool
    {
        $individual = strtolower(UserTypeEnum::INDIVIDUAL->value);

        return strtolower($user->type) === $individual;
    }
}
