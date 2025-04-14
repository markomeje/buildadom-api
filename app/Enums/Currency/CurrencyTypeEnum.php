<?php

declare(strict_types=1);

namespace App\Enums\Currency;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum CurrencyTypeEnum: string
{
    use UsefulEnums;

    case FIAT = 'fiat';
    case CRYPTO = 'crypto';

}
