<?php


namespace App\Services;
use App\Models\{User, Business, Role};
use App\Actions\{CreateUserAction, SaveVerificationAction};
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
      $user = CreateUserAction::handle(['email' => $data['email'], 'phone' => $data['phone'], 'type' => $data['type'], 'address' => $data['address'], 'password' => $data['password'], 'status' => 'active']);

      strtolower($data['type']) === 'business' ? Business::create(['name' => $data['business_name'], 'website' => $data['website'], 'cac_number' => $data['cac_number'], 'user_id' => $user->id, 'status' => 'active']) : $user->update(['firstname' => $data['firstname'], 'lastname' => $data['lastname']]);
      Role::create(['name' => 'marchant', 'user_id' => $user->id]);
      SaveVerificationAction::handle($user, 'phone');
    });
  }

}
