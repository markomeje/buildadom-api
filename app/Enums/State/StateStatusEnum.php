<?php

namespace App\Enums\State;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum StateStatusEnum: string
{
  use UsefulEnums;

  case ACTIVE = 'active';
  case DISABLED = 'disabled';

}
