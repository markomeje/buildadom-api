<?php

namespace App\Enums\Escrow;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum EscrowAccountStatusEnum: string
{
  use UsefulEnums;

  case PENDING = 'pending';
  case ACTIVE = 'active';

}
