<?php

namespace App\Enums\Order;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum OrderTrackingStatusEnum: string
{

  use UsefulEnums;

  case DISPATCHED = 'dispatched';
  case ACCEPTED = 'accepted';

  case ARRIVED = 'arrived';
  case CONFIRMED = 'confirmed';
  case PENDING = 'pending';

}
