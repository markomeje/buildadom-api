<?php

namespace App\Enums\Cart;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum CartStatusEnum: string
{

  use UsefulEnums;
  case FULFILLED = 'fulfilled';
  case PENDING = 'pending';
  case ACTIVE = 'active';

}