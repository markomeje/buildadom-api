<?php

namespace App\Enums\Country;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum CountryStatusEnum: string
{
  use UsefulEnums;

  case SELECTED = 'selected';
  case ACTIVE = 'active';
  case DISABLED = 'disabled';

}
