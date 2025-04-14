<?php

declare(strict_types=1);

namespace App\Enums\Currency;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum CurrencyStatusEnum: string
{
    use UsefulEnums;

    case ACTIVE = 'active';
    case DISABLED = 'disabled';

}
