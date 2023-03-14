<?php


namespace App\Services;
use App\Models\{Business, User};
use Exception;

/**
 * Service class
 */
class VerificationService
{

	/**
	 * The user to be verified
	 */
	private $user_id;

	/**
	 * Types of info to be verified
	 * @return void
	 */
	private $types = ['phone', 'email'];

	/**
	 * 
	 */
	public function __construct($user_id)
	{
		$this->user_id = $user_id;
		if(!User::where(['user_id' => $this->user_id])->exists()) {
			throw new Exception('Invalid user passed to create business profile');
		}
	}
	
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
		Business::create([
			'user_id' => $this->user_id,
			'name' => $info->business_name,
			'website' => $info->website,
			'cac_number' => $info->cac_number,
		]);
	}


}












