<?php


namespace App\Services\V1\Store;
use \Exception;
use App\Models\Store\Store;
use App\Utility\Responser;
use App\Utility\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class StoreService
{

  /**
   * @param Request $request
   * @return JsonResponse
   */
	public function list(Request $request): JsonResponse
	{
    try {
      $limit = $request->limit ?? 20;
      $stores = Store::published()->with(['country', 'city'])->latest()->paginate($limit);
      return Responser::send(Status::HTTP_OK, $stores, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
    }
	}

}
