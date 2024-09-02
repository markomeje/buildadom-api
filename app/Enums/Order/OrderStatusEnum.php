<?php

namespace App\Enums\Order;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum OrderStatusEnum: string
{
  use UsefulEnums;

  case ACCEPTED = 'accepted';
  case DISPATCHED = 'dispatched';
  case PLACED = 'placed';
  case FULFILLED = 'fulfilled';
  case DELIVERED = 'delivered';
  case PENDING = 'pending';
  case PROCESSED = 'processed';
  case DECLINED = 'declined';
  case CANCELLED = 'cancelled';


}
