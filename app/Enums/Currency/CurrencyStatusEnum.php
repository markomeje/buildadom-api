<?php

namespace App\Enums\Currency;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum CurrencyStatusEnum: string
{
  use UsefulEnums;

  case ACTIVE = 'active';
  case DISABLED = 'disabled';

}
