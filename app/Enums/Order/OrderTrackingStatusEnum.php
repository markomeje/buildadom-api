<?php

namespace App\Enums\Order;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum OrderTrackingStatusEnum: string
{

  use UsefulEnums;

  case DISPATCHED = 'dispatched';

  case DELIVERED = 'delivered';
  case PROCESSED = 'processed';
  case PENDING = 'pending';
  case PROCESSING = 'processing';

}
