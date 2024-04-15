<?php

namespace App\Traits;
use App\Models\Store\Store;
use App\Models\User;
use Exception;

trait MerchantTrait
{
  /**
   * @param int $user_id
   * @throws Exception
   * @return User
   */
  public function getMerchantUser(int $user_id)
  {
    if(!Store::where('user_id', $user_id)->exists()) {
      throw new Exception('Invalid merchant store.');
    }

    return User::find($user_id);
  }

}