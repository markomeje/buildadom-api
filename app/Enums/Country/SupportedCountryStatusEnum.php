<?php

namespace App\Enums\Country;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum SupportedCountryStatusEnum: string
{
    use UsefulEnums;

    case ACTIVE = 'active';
    case DISABLED = 'disabled';

}
