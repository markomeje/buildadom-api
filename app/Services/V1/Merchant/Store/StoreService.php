<?php

namespace App\Services\V1\Merchant\Store;
use App\Actions\UploadImageAction;
use App\Models\Store\Store;
use App\Services\BaseService;
use App\Utility\Responser;
use App\Utility\Uploader;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class StoreService extends BaseService
{

  public function __construct(private Uploader $uploader)
  {
    $this->uploader = $uploader;
  }

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
   * @param int $id
   * @param Request $request
   * @return JsonResponse
   */
  public function update($id, Request $request): JsonResponse
  {
    try {
      $store = Store::query()->find($id);
      if(empty($store)) {
        return Responser::send(JsonResponse::HTTP_NOT_FOUND, $store, 'Store record not found. Try again.');
      }

      $store->update([
        'name' => $request->name,
        'country_id' => $request->country_id,
        'description' => $request->description,
        'address' => $request->address,
        'city_id' => $request->city_id,
        'published' => (boolean)$request->published,
      ]);

      return Responser::send(JsonResponse::HTTP_OK, $store, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e->getMessage());
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

      $store->update(['published' => (boolean)$request->published]);
      return Responser::send(JsonResponse::HTTP_OK, $store, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
    }
  }

  public function upload($id, Request $request)
  {
    try {
      $store = Store::where(['user_id' => auth()->id(), 'id' => $id])->first();
      if(empty($store)) {
        return Responser::send(JsonResponse::HTTP_NOT_FOUND, $store, 'Store record not found. Try again.');
      }

      $file = $request->file('store_file');
      $upload_type = $request->upload_type;
      switch ($upload_type) {
        case 'logo':
          $uploaded_file = $this->uploader->uploadToS3($file, $store->logo);
          $store->logo = $uploaded_file;
          break;
        case 'banner':
          $uploaded_file = $this->uploader->uploadToS3($file, $store->banner);
          $store->banner = $uploaded_file;
          break;
      }

      $store->save();
      return Responser::send(JsonResponse::HTTP_OK, $store, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
    }
  }

}
