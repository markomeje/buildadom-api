<?php


namespace App\Services;
use App\Models\{Store, Country};
use \Exception;


class StoreService
{
	
  /**
   * Create store
   * @param array $data
   */
	public function create(array $data): Store
	{
		$country = $data['country_id'] ?? 0;
		if (empty(Country::find($country))) {
			throw new Exception('Invalid country selected');
		}

		return Store::create([
			'user_id' => auth()->id(),
			...$data
		]);
	}

  /**
   * Update store
   * @param array $data, int $id
   */
	public function update(array $data, $id)
	{
		$country = $data['country_id'] ?? 0;
		if (empty(Country::find($country))) {
			throw new Exception('Invalid country selected');
		}

		if ($store = Store::find($id)) {
      $store->update($data);
      return $store;
		}else {
      throw new Exception('Store not found.');
    }
	}
}












