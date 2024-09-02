<?php

use App\Utility\Help;
use App\Utility\Responser;
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

 /**
  * @return int
  */
if(!function_exists('generateRandomDigits')) {
  function generateRandomDigits($length = 6): int
  {
    $digits = str_pad('', $length, '0', STR_PAD_LEFT);
    $digits = str_shuffle($digits);
    return (int)substr($digits, 0, $length);
  }
}

if(!function_exists('responser')) {
  function responser() {
    return (new Responser());
  }
}
