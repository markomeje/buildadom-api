<?php

namespace App\Enums\V1\Order;

enum OrderStatusEnum: string
{
  case ACTIVE = 'active';
  case PENDING = 'pending';

  public static function array(): array
  {
    return array_column(self::cases(), 'value');
  }

}
