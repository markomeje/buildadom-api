<?php

declare(strict_types=1);

namespace App\Enums\Cart;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum CartItemStatusEnum: string
{
    use UsefulEnums;
    case FULFILLED = 'fulfilled';
    case PENDING = 'pending';
    case PROCESSED = 'processed';

}
