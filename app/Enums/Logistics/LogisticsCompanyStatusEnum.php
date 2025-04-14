<?php

declare(strict_types=1);

namespace App\Enums\Logistics;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum LogisticsCompanyStatusEnum: string
{
    use UsefulEnums;

    case ACTIVE = 'active';
    case VERIFIED = 'verified';
    case UNVERIFIED = 'unverified';

}
