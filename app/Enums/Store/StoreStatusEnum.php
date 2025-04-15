<?php

namespace App\Enums\Store;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum StoreStatusEnum: string
{
    use UsefulEnums;

    case ACTIVE = 'active';
    case BANNED = 'banned';
    case SUSPENDED = 'suspended';
    case DISABLED = 'disabled';

}
