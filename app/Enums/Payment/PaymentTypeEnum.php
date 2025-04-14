<?php

declare(strict_types=1);

namespace App\Enums\Payment;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum PaymentTypeEnum: string
{
    use UsefulEnums;

    case CHARGE = 'charge';
    case TRANSFER = 'transfer';

}
