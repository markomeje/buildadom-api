<?php

namespace App\Helpers;
use Propaganistas\LaravelPhone\PhoneNumber as Phone;


class PhoneHelper
{

  /**
   * Format phone number
   *
   * @return ?string
   */
  public static function formatPhoneNumber(string $phone): ?string
  {
    return (string)(new Phone($phone));
  }

}
