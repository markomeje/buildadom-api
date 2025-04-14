<?php

declare(strict_types=1);

namespace App\Enums\Store;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum StoreUploadTypeEnum: string
{
    use UsefulEnums;

    case LOGO = 'logo';
    case BANNER = 'banner';

}
