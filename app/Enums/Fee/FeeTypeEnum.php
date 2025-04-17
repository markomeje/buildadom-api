<?php

namespace App\Enums\Fee;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum FeeTypeEnum: string
{
    use UsefulEnums;

    case FLAT_FEE = 'FLAT_FEE';
    case PERCENTAGE_FEE = 'PERCENTAGE_FEE';

}
