<?php

namespace App\Traits;
use Propaganistas\LaravelPhone\PhoneNumber as Phone;


trait PhoneNumberTrait
{
  /**
   * Format phone number
   *
   * @return ?string
   */
  public function formatPhoneNumber(string $phone): ?string
  {
    $phone = (string)(new Phone($phone));
    return $phone;
  }

  public static function getOnlyNumbers($string, $length = 0): string
  {
    preg_match_all('!\d+!', $string, $matches);
    $string = implode('', $matches[0]);
    unset($matches);
    return substr($string, $length);
  }
}
