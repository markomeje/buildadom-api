<?php

namespace App\Enums\File;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum UploadedFileRoleEnum: string
{
  use UsefulEnums;

  case MAIN = 'main';
  case OTHERS = 'others';

}
