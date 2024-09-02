<?php

namespace App\Enums\Sms;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum SmsStatusEnum: string
{
  use UsefulEnums;

  case PENDING = 'pending';
  case SENDING = 'sending';
  case SENT = 'sent';
  case ERROR = 'error';
}
