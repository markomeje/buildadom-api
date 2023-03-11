<?php


namespace App\Services;
use App\Models\Store;
use App\Http\Requests\StoreRequest;

/**
 * Service class
 */
class StoreService
{
	
	public function create(StoreRequest $request): Store
	{
		return Store::create([
			'user_id' => auth()->id(),
			'name' => $request->name,
			'description' => $request->description,
			'address' => $request->address,
			'location' => $request->location,
		]);
	}

	public function update(StoreRequest $request, Store $store): Store
	{
		$store->name = $request->name;
		$store->description = $request->description;
		$store->address = $request->address;
		$store->location = $request->location;
		return $store->update();
	}
}