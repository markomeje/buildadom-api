<?php

declare(strict_types=1);

namespace App\Enums\Order;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum OrderSettlementStatusEnum: string
{
    use UsefulEnums;

    case PENDING = 'PENDING';
    case PROCESSED = 'PROCESSED';
    case SETTLED = 'SETTLED';

}
