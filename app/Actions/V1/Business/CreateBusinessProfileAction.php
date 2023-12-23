<?php

namespace App\Actions\V1\Business;
use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\UserTypeCheckerTrait;
use App\Models\Business\BusinessProfile;

class CreateBusinessProfileAction
{

  use UserTypeCheckerTrait;

  /**
   * Handle User request
   *
   * @param Request $request
   * @param User $user
   * @return BusinessProfile
   */
  public static function handle(Request $request, User $user): ?BusinessProfile
  {
    return BusinessProfile::create([
      'name' => $request->business_name,
      'website' => $request->website,
      'cac_number' => $request->cac_number,
      'user_id' => $user->id
    ]);
  }
}
