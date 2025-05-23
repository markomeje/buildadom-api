<?php

namespace App\Enums\Kyc;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum KycFileSideEnum: string
{
    use UsefulEnums;

    case FRONT = 'front';
    case BACK = 'back';

}
