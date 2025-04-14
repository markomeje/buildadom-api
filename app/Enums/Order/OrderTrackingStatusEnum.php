<?php

declare(strict_types=1);

namespace App\Enums\Order;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum OrderTrackingStatusEnum: string
{
    use UsefulEnums;

    case DISPATCHED = 'dispatched';

    case DELIVERED = 'delivered';
    case PENDING = 'pending';
    case PROCESSING = 'processing';

}
