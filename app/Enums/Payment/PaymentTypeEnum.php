<?php

namespace App\Enums\Payment;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum PaymentTypeEnum: string
{
  use UsefulEnums;

  case CHARGE = 'charge';
  case TRANSFER = 'transfer';

}
