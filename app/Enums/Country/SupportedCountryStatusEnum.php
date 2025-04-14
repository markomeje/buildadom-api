<?php

declare(strict_types=1);

namespace App\Enums\Country;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum SupportedCountryStatusEnum: string
{
    use UsefulEnums;

    case ACTIVE = 'active';
    case DISABLED = 'disabled';

}
