<?php

namespace App\Helpers;
use Propaganistas\LaravelPhone\PhoneNumber as Phone;


class UtilityHelper
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

  public static function getOnlyNumbers($string, $length = 0): string
  {
    preg_match_all('!\d+!', $string, $matches);
    $string = implode('', $matches[0]);
    unset($matches);
    return substr($string, $length);
  }

  public static function generateRandomDigits(): int
  {
    return rand(000000, 999999);
  }

}
