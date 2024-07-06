<?php

namespace App\Enums\Escrow;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum EscrowBalanceTypeEnum: string
{
  use UsefulEnums;

  case CREDIT = 'credit';
  case DEBIT = 'debit';

}
