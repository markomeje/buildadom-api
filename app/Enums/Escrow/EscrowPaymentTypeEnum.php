<?php

namespace App\Enums\Escrow;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum EscrowPaymentTypeEnum: string
{
  use UsefulEnums;

  case DEPOSIT = 'DEPOSIT';
  case WITHDRAWAL = 'WITHDRAWAL';

}
