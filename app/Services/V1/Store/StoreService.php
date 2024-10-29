<?php


namespace App\Services\V1\Store;
use \Exception;
use App\Models\Store\Store;
use App\Services\BaseService;
use App\Utility\Responser;
use App\Utility\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class StoreService extends BaseService
{

  /**
   * @return JsonResponse
   */
	public function list(): JsonResponse
	{
    try {
      $stores = Store::published()->with(['state', 'city'])->latest()->get();
      return responser()->send(Status::HTTP_OK, $stores, 'Operation successful.');
    } catch (Exception $e) {
      return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
    }
	}

  /**
   * @return JsonResponse
   */
	public function show($id): JsonResponse
	{
    try {
      $store = Store::published()->with(['state', 'city'])->find($id);
      return responser()->send(Status::HTTP_OK, $store, 'Operation successful.');
    } catch (Exception $e) {
      return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, 'Operation failed. Try again.');
    }
	}

}
