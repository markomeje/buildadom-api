<?php

use App\Models\Country;
use App\Models\Store\Store;
use App\Models\User;
use Propaganistas\LaravelPhone\PhoneNumber;


if(!function_exists('getStoreMerchant')) {
  function getStoreMerchant($user_id) {
    if(!Store::where('user_id', $user_id)->exists()) {
      throw new Exception('Invalid merchant store.');
    }

    return User::find($user_id);
  }
}

if(!function_exists('defaultCountry')) {
  function defaultCountry() {
    $country = Country::where('iso2', 'NG')->first();
    if(empty($country)) {
      throw new Exception('An error occurred with default country');
    }

    return $country;
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
