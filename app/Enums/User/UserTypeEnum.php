<?php

namespace App\Enums\User;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum UserTypeEnum: string
{
  use UsefulEnums;

  case INDIVIDUAL = 'individual';
  case BUSINESS = 'business';

}
