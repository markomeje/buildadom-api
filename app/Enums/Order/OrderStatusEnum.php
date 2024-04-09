<?php

namespace App\Enums\Order;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum OrderStatusEnum: string
{
  use UsefulEnums;

  case PENDING = 'pending';
  case PAID = 'paid';

}
