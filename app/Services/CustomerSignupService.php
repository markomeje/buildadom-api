<?php

namespace App\Services;
use App\Models\{User, Role};
use App\Actions\CreateUserAction;
use Illuminate\Support\Facades\DB;
use App\Notifications\CustomerSignupNotification;
use Exception;


class CustomerSignupService
{
  /**
   * Signup User
   * @param array $data
   */
   public function signup(array $data): void
   {
      DB::transaction(function() use($data) {
         $user = CreateUserAction::handle(['email' => $data['email'], 'phone' => $data['phone'], 'type' => 'customer', 'address' => '', 'firstname' => $data['firstname'], 'lastname' => $data['lastname'], 'password' => $data['password'], 'status' => 'active']);

         Role::create(['name' => 'customer', 'user_id' => $user->id]);
         $user->notify(new CustomerSignupNotification());
      });
   }

}
