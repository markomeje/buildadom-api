<?php


namespace App\Services;
use App\Models\{Store, Country};
use \Exception;


class StoreService
{
	
	public function create(array $data): Store
	{
		$country = $data['country_id'] ?? 0;
		if (empty(Country::find($country))) {
			throw new Exception('Invalid country selected');
		}

		$store = Store::create([
			'user_id' => auth()->id(),
			...$data
		]);

		if (empty($store)) {
			throw new Exception('Error creating store. Try again');
		}

		return $store;
	}

	public function update(array $data, $id)
	{
		$country = $data['country_id'] ?? 0;
		if (empty(Country::find($country))) {
			throw new Exception('Invalid country selected');
		}

		$store = Store::find($id);
		if (empty($store)) {
			throw new Exception('Store not found.');
		}
		
		if(!$store->update($data)) {
			throw new Exception('Error updating store info. Try again.');
		}

		return $store;
	}
}












