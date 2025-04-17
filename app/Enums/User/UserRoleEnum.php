<?php

namespace App\Enums\User;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum UserRoleEnum: string
{
    use UsefulEnums;

    case SYSTEM_CONTROL = 'system_control';
    case MERCHANT = 'merchant';
    case CUSTOMER = 'customer';
    case ADMIN = 'admin';
    case SUPER_ADMIN = 'super_admin';
    case SYSTEM_ADMIN = 'system_admin';

}
