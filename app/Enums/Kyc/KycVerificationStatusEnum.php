<?php

namespace App\Enums\Kyc;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum KycVerificationStatusEnum: string
{
  use UsefulEnums;

  case VERIFIED = 'verified';
  case PENDING = 'pending';
  case FAILED = 'failed';
  case INVALID = 'invalid';

}
