<?php

namespace App\Actions;
use App\Models\{User, Business, Verification};
use App\Http\Requests\SignupRequest;
use Illuminate\Support\Facades\DB as Database;
use App\Notifications\PhoneVerificationNotification;
use Illuminate\Support\Facades\Notification;
use Propaganistas\LaravelPhone\PhoneNumber;
use Hash;

/**
 * Like a black box
 * With one method
 * 
 */
class SignupAction 
{
	/**
	 * Handle Signup request
	 * 
	 * @return Signup model
	 */
	public function handle(SignupRequest $request)
	{
		return Database::transaction(function() use ($request) {
			$type = strtolower($request->type);
			$phone = (string)(new PhoneNumber($request->phone));

			$user = User::create([
				'firstname' => $request->firstname,
		        'email' => $request->email,
		        'phone' => $phone,
		        'lastname' => $request->lastname,
		        'type' => $type,
		        'status' => 'active',
		        'address' => $request->address,
		        'password' => Hash::make($request->password)
			]);

			if ($type === 'business') {
				Business::create([
					'user_id' => $user->id,
					'name' => $request->business_name,
					'website' => $request->website,
					'cac_number' => $request->cac_number,
				]);
			}

			$token = rand(100000, 999999);
			Verification::create([
				'type' => 'phone', 
				'code' => $token,
				'reference' => str()->random(64),
				'user_id' => $user->id,
			]);

			$user->notify(new PhoneVerificationNotification($token));
			return $user;
		});
	}
}
















