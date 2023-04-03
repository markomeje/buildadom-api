<?php

namespace App\Actions;
use App\Models\{User, Business};
use Illuminate\Support\Facades\DB;
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
		$signup = function() use($data) {
      $type = strtolower($data['type'] ?? '');

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

			VerificationService::sendVerificationCode(['user' => $user, 'type' => 'phone']);
			return $user;
		};

    return DB::transaction($signup);
	}
}
















