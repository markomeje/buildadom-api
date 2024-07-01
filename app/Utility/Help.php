<?php

namespace App\Utility;
use App\Models\Country;
use Propaganistas\LaravelPhone\PhoneNumber;
use Exception;


class Help
{
  /**
   * @param string $string
   * @param int $length
   * @return string
   */
  public function getOnlyNumbers($string, $length = 0)
  {
    preg_match_all('!\d+!', $string, $matches);
    $string = implode('', $matches[0]);
    unset($matches);
    return substr($string, $length);
  }

  /**
   * @return Country
   */
  public function getDefaultCountry()
  {
    $country = Country::where('iso2', 'NG')->first();
    if(empty($country)) {
      throw new Exception('An error occurred with default country');
    }

    return $country;
  }
  public function formatPhoneNumber($phone)
  {
    return (string)(new PhoneNumber($phone));
  }

  /**
   * @return int
   */
  public function generateRandomDigits($length = 6)
  {
    $digits = str_pad('', $length, '0', STR_PAD_LEFT);
    $digits = str_shuffle($digits);
    return (int)substr($digits, 0, $length);
  }

}
