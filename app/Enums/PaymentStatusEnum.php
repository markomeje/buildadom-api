<?php

namespace App\Enums;

enum PaymentStatusEnum: int
{
  case PAID = 1;
  case NOT_PAID = 0;

  public static function array(): array
  {
    return array_column(self::cases(), 'name');
  }

}
