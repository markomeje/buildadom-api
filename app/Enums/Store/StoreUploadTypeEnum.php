<?php

namespace App\Enums\Store;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum StoreUploadTypeEnum: string
{
    use UsefulEnums;

    case LOGO = 'logo';
    case BANNER = 'banner';

}
