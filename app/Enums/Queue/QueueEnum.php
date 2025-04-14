<?php

declare(strict_types=1);

namespace App\Enums\Queue;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum QueueEnum: string
{
    use UsefulEnums;

    case ESCROW = 'escrow';
    case ORDER = 'order';
    case SMS = 'sms';
    case EMAIL = 'email';
    case PAYMENT = 'payment';
    case TASK = 'task';
}
