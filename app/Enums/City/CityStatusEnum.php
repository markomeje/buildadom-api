<?php

namespace App\Enums\City;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum CityStatusEnum: string
{
  use UsefulEnums;

  case ACTIVE = 'active';
  case DISABLED = 'disabled';

}
