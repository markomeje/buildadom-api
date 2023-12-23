<?php


namespace App\Services\Business;
use App\Models\{Business};
use App\Models\Business\BusinessProfile;

/**
 * Service class
 */
class BuisnessProfileService
{

  public function __construct(BusinessProfile $businessProfile)
  {
    $this->businessProfile = $businessProfile;
  }

	/**
	 * Create a Business profile record
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












