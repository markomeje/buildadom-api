<?php

namespace App\Enums\Upload;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum UploadRoleEnum: string
{
    use UsefulEnums;

    case MAIN = 'main';
    case OTHERS = 'others';

}
