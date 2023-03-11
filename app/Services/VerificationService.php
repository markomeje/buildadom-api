<?php


namespace App\Services;
use App\Models\Verification;
use Exception;

/**
 * Service class
 */
class VerificationService
{

	/**
	 * Types of info to be verified
	 * @return void
	 */
	private $types = ['phone', 'email'];
	
	/**
	 * Create a verification record
	 * 
	 * @return Verification model
	 * @param info containung the verification code and type
	 * @types 'phone' || 'email'
	 */
	public function create($info): Verification
	{
		$info = (object)$info;
		if(!in_array($info->type, $this->types)) {
			throw new Exception('Invalid verification type passed');
		}

		return Verification::create([
			'user_id' => $info->user_id,
			'expiry' => now()->addMinutes(60),
			'code' => $info->code,
			'type' => $info->type,
			'verified' => false,
		]);
	}

	/**
	 * 
	 */
	public function update($info): Verification
	{	
		$verification = Verification::find($info->id);
		$verification->code = $info->code;
		$verification->verified = $info->verified ?? false;
		return $verification->update();
	}

	/**
	 * 
	 */
	public function exists($info): ?Verification
	{
		$info = (object)$info;
		return Verification::where([
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












