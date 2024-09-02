<?php

namespace App\Enums\Currency;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum CurrencyTypeEnum: string
{
  use UsefulEnums;

  case FIAT = 'fiat';
  case CRYPTO = 'crypto';

}
