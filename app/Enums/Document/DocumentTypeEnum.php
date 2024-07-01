<?php

namespace App\Enums\Document;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum DocumentTypeEnum: string
{
  use UsefulEnums;

  case DRIVERS_LISCENCE = 'DRIVERS_LISCENCE';
  case VOTERS_CARD = 'VOTERS_CARD';
  case INTERNATIONAL_PASSPORT = 'INTERNATIONAL_PASSPORT';
  case NATIONAL_IDENTITY_CARD = 'NATIONAL_IDENTITY_CARD';

}
