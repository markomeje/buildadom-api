<?php

namespace App\Traits\V1;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\V1\UserTrait;
use App\Models\Business\BusinessProfile;


trait BusinessProfileTrait
{
  use UserTrait;

  /**
   * Handle User request
   *
   * @param Request $request
   * @param User $user
   * @return BusinessProfile
   */
  public function createUserBusinessProfile(Request $request, User $user): ?BusinessProfile
  {
    $profile = null;
    if($this->isBusinnesUser($user)) {
      $profile = BusinessProfile::create([
        'name' => $request->business_name,
        'website' => $request->website,
        'cac_number' => $request->cac_number,
        'user_id' => $user->id
      ]);
    }

    return $profile;
  }
}
