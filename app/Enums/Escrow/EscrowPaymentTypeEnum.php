<?php

declare(strict_types=1);

namespace App\Enums\Escrow;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum EscrowPaymentTypeEnum: string
{
    use UsefulEnums;

    case DEPOSIT = 'DEPOSIT';
    case WITHDRAWAL = 'WITHDRAWAL';

}
