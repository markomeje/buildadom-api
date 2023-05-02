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
		return Store::create([
			'user_id' => auth()->id(),
      'published' => false,
			...$data
		]);
	}

  /**
   * Update store
   * @param array $data, int $id
   */
	public function update(array $data, $id)
	{
    return Store::findOrFail($id)->update($data);
	}

  /**
   * Get store
   * @param array $data, int $id
   */
  public static function where(array $data, $id)
  {
    return Store::with(['images'])->where([
      ...$data,
      'id' => $id
    ])->first();
  }
}












