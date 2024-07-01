<?php

use App\Models\Country;
use App\Models\Store\Store;
use App\Models\User;
use App\Utility\Help;
use Propaganistas\LaravelPhone\PhoneNumber;


if(!function_exists('help')) {
  function help() {
    return (new Help());
  }
}

if(!function_exists('formatPhoneNumber')) {
  function formatPhoneNumber($phone) {
    return (string)(new PhoneNumber($phone));
  }
}

if(!function_exists('getOnlyNumbers')) {
  function getOnlyNumbers($string, $length = 0) {
    preg_match_all('!\d+!', $string, $matches);
    $string = implode('', $matches[0]);

    unset($matches);
    return substr($string, $length);
  }
}

if(!function_exists('generateRandomDigits')) {
  /**
   * @return int
   */
  function generateRandomDigits($length = 6): int
  {
    $digits = str_pad('', $length, '0', STR_PAD_LEFT);
    $digits = str_shuffle($digits);
    return (int)substr($digits, 0, $length);
  }
}
