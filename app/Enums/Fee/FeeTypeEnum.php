<?php

namespace App\Enums\Fee;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum FeeTypeEnum: string
{
  use UsefulEnums;

  case FLAT_FEE = 'flat_fee';
  case PERCENTAGE_FEE = 'percentage_fee';

}
