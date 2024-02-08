<?php

namespace App\Utility;
use Propaganistas\LaravelPhone\PhoneNumber;


class Help
{

  /**
   * Format phone number
   *
   * @return ?string
   */
  public static function formatPhoneNumber(string $phone): ?string
  {
    return (string)(new PhoneNumber($phone));
  }

  public static function getOnlyNumbers($string, $length = 0): string
  {
    preg_match_all('!\d+!', $string, $matches);
    $string = implode('', $matches[0]);
    unset($matches);
    return substr($string, $length);
  }

  /**
   * @return int
   */
  public static function generateRandomDigits(): int
  {
    return rand(111111, 999999);
  }

}
