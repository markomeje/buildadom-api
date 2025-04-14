<?php

declare(strict_types=1);

namespace App\Enums\Business;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum BusinessProfileStatusEnum: string
{
    use UsefulEnums;

    case ACTIVE = 'active';
    case BLOCKED = 'blocked';

}
