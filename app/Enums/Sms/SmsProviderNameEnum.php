<?php

namespace App\Enums\Sms;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum SmsProviderNameEnum: string
{
    use UsefulEnums;

    case TERMII = 'TERMII';
}
