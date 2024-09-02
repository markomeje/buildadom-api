<?php

namespace App\Enums\Escrow;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum EscrowTransactionTypeEnum: string
{
  use UsefulEnums;

  case CREDIT = 'credit';
  case DEBIT = 'debit';

}
