<?php

namespace App\Enums\Order;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum OrderFulfillmentStatusEnum: string
{
    use UsefulEnums;

    case CONFIRMED = 'confirmed';
    case PENDING = 'pending';

}
