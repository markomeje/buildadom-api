<?php

namespace App\Enums\V1\Order;

enum OrderTrackingStatusEnum: string
{
  case DISPATCHED = 'dispatched';
  case ACCEPTED = 'accepted';

  case ARRIVED = 'arrived';
  case CONFIRMED = 'confirmed';
  case PENDING = 'pending';

  public static function array(): array
  {
    return array_column(self::cases(), 'value');
  }

}
