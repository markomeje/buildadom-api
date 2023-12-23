<?php

namespace App\Enums\Business;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum BusinessIdTypeEnum: string
{
  use UsefulEnums;

  case BRIVERS_LISCENCE = 'drivers_license';
  case VOTERS_CARD = 'voters_card';
  case INTERNATIONAL_PASSPORT = 'international_passport';
  case NATIONAL_IDENTITY_CARD = 'national_identity_card';

}
