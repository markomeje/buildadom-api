<?php


namespace App\Services\V1\Store;
use \Exception;
use App\Utility\Responser;
use Illuminate\Http\JsonResponse;


class StoreService
{

  /**
   * Create store
   * @param array $data
   * @return JsonResponse
   */
	public function create(array $data): JsonResponse
	{
    try {
      return Store::create([
        'user_id' => auth()->id(),
        'published' => false,
        ...$data
      ]);
      return Responser::send(JsonResponse::HTTP_OK, $kyc_file, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
    }
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
