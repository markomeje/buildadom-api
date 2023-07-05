<?php

namespace App\Enums;

enum PaymentStatusEnum: string
{
  case PAID = 'paid';
  case INITIALIZED = 'initialized';

  public static function array(): array
  {
    return array_column(self::cases(), 'name');
  }

}
