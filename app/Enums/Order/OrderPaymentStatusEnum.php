<?php

declare(strict_types=1);

namespace App\Enums\Order;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum OrderPaymentStatusEnum: string
{
    use UsefulEnums;

    case PENDING = 'pending';
    case PAID = 'paid';

}
