<?php


namespace App\Services;
use App\Models\{Reset, User};
use Illuminate\Support\Facades\DB as Database;
use App\Notifications\ResetNotification;
use Exception;

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
	public function create($data): Reset
	{
		$data = (object)$data;
		return Database::transaction(function() use($data) {
			$user = User::where(['email' => $data->email])->first();
			if (empty($user)) throw new Exception('No account found with the supplied email.');

			$code = rand(111111, 999999);
			$reset = Reset::create([
				'email' => $user->email,
				'expiry' => now()->addMinutes(60),
				'code' => $code,
				'type' => $data->type,
				'done' => false,
			]);

			$user->notify(new ResetNotification($code, $data->type))
			return $reset;
		});
	}

	/**
	 * 
	 */
	public function update($info): Reset
	{	
		$Reset = Reset::find($info->id);
		$Reset->code = $info->code;
		$Reset->verified = $info->verified ?? false;
		return $Reset->update();
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












