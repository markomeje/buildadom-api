<?php

namespace App\Services\V1\Merchant\Store;
use App\Models\Store\Store;
use App\Services\BaseService;
use App\Utility\Responser;
use App\Utility\Status;
use App\Utility\Uploader;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class StoreService extends BaseService
{
  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function create(Request $request): JsonResponse
  {
    try {
      $store = Store::create([
        'name' => $request->name,
        'country_id' => $request->country_id,
        'description' => $request->description,
        'address' => $request->address,
        'city_id' => $request->city_id,
        'user_id' => auth()->id(),
        'published' => false,
      ]);

      return Responser::send(Status::HTTP_OK, $store, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e->getMessage());
    }
  }

  /**
   * @return JsonResponse
   * @param Request $request
   */
  public function list(Request $request): JsonResponse
  {
    try {
      $stores = Store::owner()->with(['country', 'city', 'state'])->get();
      return Responser::send(Status::HTTP_OK, $stores, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
    }
  }

  /**
   * @param int $id
   * @param Request $request
   * @return JsonResponse
   */
  public function update($id, Request $request): JsonResponse
  {
    try {
      $store = Store::owner()->find($id);
      if(empty($store)) {
        return Responser::send(Status::HTTP_NOT_FOUND, $store, 'Store record not found. Try again.');
      }

      $store->update([
        'name' => $request->name,
        'country_id' => $request->country_id,
        'description' => $request->description,
        'address' => $request->address,
        'city_id' => $request->city_id,
        'published' => (boolean)$request->published,
      ]);

      return Responser::send(Status::HTTP_OK, $store, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e->getMessage());
    }
  }

  /**
   * @param Request $request,
   * @param $id
   */
  public function publish($id, Request $request)
  {
    try {
      $store = Store::owner()->find($id);
      if(empty($store)) {
        return Responser::send(Status::HTTP_NOT_FOUND, null, 'Store record not found. Try again.');
      }

      if(empty($store->banner) || empty($store->logo)) {
        return Responser::send(Status::HTTP_NOT_ACCEPTABLE, null, 'Store banner and logo must be uploaded before publishing a store');
      }

      $store->update(['published' => (boolean)$request->published]);
      return Responser::send(Status::HTTP_OK, $store, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
    }
  }

}
