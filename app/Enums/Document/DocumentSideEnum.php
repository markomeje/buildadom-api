<?php

namespace App\Enums\Document;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum DocumentSideEnum: string
{
  use UsefulEnums;

  case FRONT = 'front';
  case BACK = 'back';

}
