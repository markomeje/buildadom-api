<?php

namespace App\Actions;
use App\Models\{User, Business};
use App\Http\Requests\SignupRequest;
use Illuminate\Support\Facades\DB as Database;
use App\Services\VerificationService;
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

			$token = random_int(100000, 999999);
			$verification = (new VerificationService())->create([
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
















