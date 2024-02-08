<?php

namespace App\Enums\Payment;

use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum PaymentStatusEnum: string
{
  use UsefulEnums;

  case PAID = 'paid';
  case INITIALIZED = 'initialized';

}
