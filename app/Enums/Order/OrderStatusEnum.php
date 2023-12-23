<?php

namespace App\Enums\V1\Order;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum OrderStatusEnum: string
{
  use UsefulEnums;

  case ACTIVE = 'active';
  case PENDING = 'pending';

}
