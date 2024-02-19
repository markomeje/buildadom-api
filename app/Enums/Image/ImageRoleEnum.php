<?php

namespace App\Enums\Image;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum ImageRoleEnum: string
{
  use UsefulEnums;

  case MAIN = 'main';
  case OTHERS = 'others';

}
