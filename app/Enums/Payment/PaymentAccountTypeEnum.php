<?php

namespace App\Enums\Payment;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum PaymentAccountTypeEnum: string
{
  use UsefulEnums;

  case ESCROW = 'ESCROW';
  case DIRECT = 'DIRECT';

}
