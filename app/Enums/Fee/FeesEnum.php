<?php

namespace App\Enums\Fee;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum FeesEnum: string
{
  use UsefulEnums;

  case ESCROW_DEPOSIT_FEE = 'escrow_deposit_fee';
  case VAT = 'vat';
  case ESCROW_DISBURSEMENT_FEE = 'escrow_disbursement_fee';
  case ESCROW_WITHDRAWAL_FEE = 'escrow_withdrawal_fee';
  case PAYMENT_FEE = 'payment_fee';

}
