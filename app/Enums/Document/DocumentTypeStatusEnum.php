<?php

namespace App\Enums\Document;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum DocumentTypeStatusEnum: string
{
  use UsefulEnums;

  case ACTIVE = 'active';
  case DISABLED = 'disabled';

}
