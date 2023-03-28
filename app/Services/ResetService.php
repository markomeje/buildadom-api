<?php


namespace App\Services;
use App\Models\{Reset, User};
use Illuminate\Support\Facades\DB as Database;
use App\Notifications\ResetNotification;
use Exception;
use Hash;

/**
 * Service class
 */
class ResetService
{
	
	/**
	 * Create a reset record
	 * 
	 * @return Reset model
	 * @param data containung the reset code and type
	 * @types 'phone' || 'email'
	 */
	public static function create($data): Reset
	{
		$data = (object)$data;
		return Database::transaction(function() use($data) {
			$user = User::where(['email' => $data->email])->first();
			if (empty($user)) throw new Exception('No account found with the supplied email.');

			$code = random_int(111111, 999999);
			$reset = Reset::create([
				'email' => $user->email,
				'expiry' => now()->addMinutes(10),
				'code' => $code,
				'type' => $data->type,
				'done' => false,
			]);

			$user->notify(new ResetNotification($code, $data->type));
			return $reset;
		});
	}

	/**
	 * 
	 */
	public static function update($info): Reset
	{	
		$info = (object)$info;
		return Database::transaction(function() use($info) {
			$reset = Reset::where(['code' => $info->code])->first();
			if (empty($reset)) throw new Exception('Invalid reset code');

			$user = User::where(['email' => $reset->email])->first();
			switch ($info->type) {
				case 'password':
					$user->password = Hash::make($info->password);
					$user->update();
					break;
				default:
					// code...
					break;
			}

			$reset->done = true;
			$reset->code = null;
			$reset->update();
			
			return $reset;
		});
	}

	/**
	 * 
	 */
	public function exists($info): ?Reset
	{
		$info = (object)$info;
		return Reset::where([
			'code' => $info->code,
			'type' => $info->type
		])->latest()->first();	
	}

	/**
	 * @return boolean
	 */
	public function verified($verified)
	{
		return (boolean)$verified === true;
	}

}












