<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
  case ACTIVE = 'active';
  case PASSIVE = 'passive';

  public static function array(): array
  {
    return array_column(self::cases(), 'name');
  }

}
