<?php


namespace App\Services;
use App\Models\{Business, User};
use Exception;

/**
 * Service class
 */
class BusinessService
{
	
	/**
	 * Create a verification record
	 * 
	 * @return Verification model
	 * @param info containung the verification code and type
	 *
	 */
	public function create(array $data, int $user_id): Verification
	{
		Business::create([
			'user_id' => $user_id,
			...$data
		]);
	}


}












