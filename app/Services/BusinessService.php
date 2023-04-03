<?php


namespace App\Services;
use App\Models\{Business};
use Exception;

/**
 * Service class
 */
class BusinessService
{
	
	/**
	 * Create a Business account record
	 * 
	 * @return Business
	 * @param array $data
	 *
	 */
	public function create(array $data): Business
	{
		return Business::create([
			...$data
		]);
	}

}












