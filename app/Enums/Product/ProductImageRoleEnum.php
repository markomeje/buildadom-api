<?php

namespace App\Enums\Product;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum ProductImageRoleEnum: string
{
  use UsefulEnums;

  case MAIN = 'main';
  case OTHERS = 'others';
}
