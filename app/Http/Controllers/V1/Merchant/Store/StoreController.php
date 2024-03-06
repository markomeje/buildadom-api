<?php

namespace App\Http\Controllers\V1\Merchant\Store;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Merchant\Store\CreateStoreRequest;
use App\Http\Requests\V1\Merchant\Store\UpdateStoreRequest;
use App\Http\Requests\V1\Merchant\Store\UploadStoreFileRequest;
use App\Services\V1\Merchant\Store\StoreService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class StoreController extends Controller
{
  /**
   * Store
   * @param StoreService $store
   */
  public function __construct(public StoreService $store)
  {
    $this->store = $store;
  }

  /**
   * @param CreateStoreRequest $request
   * @return JsonResponse
   */
  public function create(CreateStoreRequest $request): JsonResponse
  {
    return $this->store->create($request);
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function list(Request $request): JsonResponse
  {
    return $this->store->list($request);
  }

  /**
   * @param UploadStoreFileRequest $request
   * @return JsonResponse
   */
  public function upload($id, UploadStoreFileRequest $request): JsonResponse
  {
    return $this->store->upload($id, $request);
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function publish($id, Request $request): JsonResponse
  {
    return $this->store->publish($id, $request);
  }

  /**
   * @param UpdateStoreRequest $request
   * @return JsonResponse
   */
  public function update($id, UpdateStoreRequest $request): JsonResponse
  {
    return $this->store->update($id, $request);
  }

}
