<?php

declare(strict_types=1);

namespace App\Enums\Kyc;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum KycFileSideEnum: string
{
    use UsefulEnums;

    case FRONT = 'front';
    case BACK = 'back';

}
