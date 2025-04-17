<?php

namespace App\Enums\User;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum UserStatusEnum: string
{
    use UsefulEnums;

    case ACTIVE = 'active';
    case PENDING = 'pending';

}
