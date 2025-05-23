<?php

namespace App\Enums\Product;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum ProductStatusEnum: string
{
    use UsefulEnums;

    case ACTIVE = 'active';
    case BANNED = 'banned';
}
