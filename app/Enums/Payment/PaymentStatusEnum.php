<?php

namespace App\Enums\Payment;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum PaymentStatusEnum: string
{
    use UsefulEnums;

    case SUCCESS = 'success';
    case INITIALIZED = 'initialized';
    case ONGOING = 'ongoing';
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case QUEUED = 'queued';
    case ABANDONED = 'abandoned';

}
