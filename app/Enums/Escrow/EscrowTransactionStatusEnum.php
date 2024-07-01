<?php

namespace App\Enums\Escrow;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum EscrowTransactionStatusEnum: string
{
  use UsefulEnums;

  case PENDING = 'pending';
  case PAID = 'paid';

}
