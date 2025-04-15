<?php

namespace App\Enums\Fee;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum FeesEnum: string
{
    use UsefulEnums;

    case ESCROW_DEPOSIT_FEE = 'ESCROW_DEPOSIT_FEE';
    case VAT = 'VAT';
    case ESCROW_DISBURSEMENT_FEE = 'ESCROW_DISBURSEMENT_FEE';
    case ESCROW_WITHDRAWAL_FEE = 'ESCROW_WITHDRAWAL_FEE';
    case PAYMENT_FEE = 'PAYMENT_FEE';

}
