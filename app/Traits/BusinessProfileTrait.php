<?php

namespace App\Traits;
use App\Models\Business\BusinessProfile;
use App\Models\User;
use Illuminate\Http\Request;

trait BusinessProfileTrait
{
    use UserTrait;

    /**
     * Handle User request
     */
    public function createUserBusinessProfile(Request $request, User $user): ?BusinessProfile
    {
        $profile = null;
        if ($this->isBusinnesUser($user)) {
            $profile = BusinessProfile::create([
                'name' => $request->business_name,
                'website' => $request->website,
                'cac_number' => $request->cac_number,
                'user_id' => $user->id,
            ]);
        }

        return $profile;
    }
}
