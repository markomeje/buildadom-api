<?php

declare(strict_types=1);

namespace App\Enums\Upload;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum UploadRoleEnum: string
{
    use UsefulEnums;

    case MAIN = 'main';
    case OTHERS = 'others';

}
