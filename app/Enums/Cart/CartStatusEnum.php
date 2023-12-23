<?php

namespace App\Enums;

use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum CartStatusEnum: string
{

  use UsefulEnums;
  case FULFILLED = 'fulfilled';

}
