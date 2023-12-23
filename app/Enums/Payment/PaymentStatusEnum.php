<?php

namespace App\Enums\V1;

use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum PaymentStatusEnum: string
{
  use UsefulEnums;

  case PAID = 'paid';
  case INITIALIZED = 'initialized';

}
