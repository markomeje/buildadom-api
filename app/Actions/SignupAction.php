<?php

namespace App\Actions;
use App\Models\{User, Business};
use Illuminate\Support\Facades\DB as Database;
use App\Services\VerificationService;
use Illuminate\Support\Facades\Notification;
use Propaganistas\LaravelPhone\PhoneNumber;
use Hash;
use Exception;

/**
 * Like a black box
 * With one method
 * 
 */
class SignupAction 
{
	/**
	 * Handle Signup data[' * 
	 * @return Signup model
	 */
	public function handle($data) {
		return Database::transaction(function() use($data) {
			$type = strtolower($data['type']);
      if (!in_array($type, User::$types)) {
        throw new Exception('Invalid user account type. Type must be either business or individual.');
      }

			$user = User::create([
				'firstname' => $data['firstname'],
        'email' => $data['email'],
        'phone' => (string)(new PhoneNumber($data['phone'])),
        'lastname' => $data['lastname'],
        'type' => $type,
        'status' => 'active',
        'address' => $data['address'],
        'password' => Hash::make($data['password'])
			]);

			if ($type === 'business') {
				Business::create([
					'user_id' => $user->id,
					'name' => $data['business_name'],
					'website' => $data['website'],
					'cac_number' => $data['cac_number'],
				]);
			}

			(new VerificationService())->send(['user' => $user, 'type' => 'phone']);
			return $user;
		});
	}
}
















