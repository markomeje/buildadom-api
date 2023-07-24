<?php

namespace App\Enums;

enum CartStatusEnum: string
{
  case ACTIVE = 'active';
  case FULFILLED = 'fulfilled';

  public static function array(): array
  {
    return array_column(self::cases(), 'value');
  }

}
