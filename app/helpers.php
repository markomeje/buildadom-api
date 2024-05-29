<?php

use App\Models\Store\Store;
use App\Models\User;



if(!function_exists('getStoreMerchant')) {
  function getStoreMerchant($user_id) {
    if(!Store::where('user_id', $user_id)->exists()) {
      throw new Exception('Invalid merchant store.');
    }

    return User::find($user_id);
  }
}