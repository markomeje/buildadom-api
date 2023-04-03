<?php


namespace App\Services;
use App\Models\{User, Country};
use App\Actions\{CreateBusinessAction, CreateUserAction, SaveVerificationAction};
use Illuminate\Support\Facades\DB;
use Exception;
use Hash;


class SignupService
{

  /**
   * Signup User
   * @param array $data
   */
  public function signup(array $data): void
  {
    DB::transaction(function() use($data) {
      $user = CreateUserAction::handle(['firstname' => $data['firstname'], 'email' => $data['email'], 'phone' => $data['phone'], 'lastname' => $data['lastname'], 'type' => $data['type'], 'status' => 'active', 'address' => $data['address'], 'password' => $data['password']]);

      if($data['type'] === 'business') CreateBusinessAction::handle(['name' => $data['business_name'], 'website' => $data['website'], 'cac_number' => $data['cac_number'], 'user_id' => $user->id]);
      SaveVerificationAction::handle($user);
    });
  }

}
