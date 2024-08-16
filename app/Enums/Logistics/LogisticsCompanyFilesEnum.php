<?php

namespace App\Enums\Logistics;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum LogisticsCompanyFilesEnum: string
{
  use UsefulEnums;

  case DRIVERS_LICENSE = 'drivers_license';
  case VEHICLE_PICTURE = 'vehicle_picture';
  case DRIVER_PICTURE = 'driver_picture';

}
