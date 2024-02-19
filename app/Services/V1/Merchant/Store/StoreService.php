<?php

namespace App\Services\V1\Merchant\Store;
use App\Actions\UploadImageAction;
use App\Models\Store\Store;
use App\Services\BaseService;
use App\Utility\Responser;
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
      $logo = $request->file('logo');
      if($logo) {
        $logo = UploadImageAction::handle($logo);
      }

      $banner = $request->file('banner');
      if($banner) {
        $banner = UploadImageAction::handle($banner);
      }

      $store = Store::create([
        ...$request->validated(),
        'user_id' => auth()->id(),
        'banner' => $banner,
        'logo' => $logo,
        'published' => false,
      ]);

      return Responser::send(JsonResponse::HTTP_OK, $store, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e->getMessage());
    }
  }

  /**
   * @return JsonResponse
   * @param Request $request
   */
  public function list(Request $request): JsonResponse
  {
    try {
      $stores = Store::with(['country', 'city', 'state'])->where(['user_id' => auth()->id()])->get();
      return Responser::send(JsonResponse::HTTP_OK, $stores, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
    }
  }

  /**
   * @param Request $request,
   * @param $id
   */
  public function publish($id, Request $request)
  {
    try {
      $store = Store::where(['user_id' => auth()->id(), 'id' => $id])->first();
      if(empty($store)) {
        return Responser::send(JsonResponse::HTTP_NOT_FOUND, $store, 'Store record not found. Try again.');
      }

      $store->update(['published' => (boolean)($request->publish)]);
      return Responser::send(JsonResponse::HTTP_OK, $store, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
    }
  }

}
