<?php

declare(strict_types=1);

namespace App\Enums\Kyc;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum KycFileStatusEnum: string
{
    use UsefulEnums;

    case ACCEPTED = 'accepted';
    case PENDING = 'pending';
    case REJECTED = 'rejected';
    case INVALID = 'invalid';

}
