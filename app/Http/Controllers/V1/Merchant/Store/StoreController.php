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
   * @param StoreService $storeService
   */
  public function __construct(public StoreService $storeService)
  {
    $this->storeService = $storeService;
  }

  /**
   * @param CreateStoreRequest $request
   * @return JsonResponse
   */
  public function create(CreateStoreRequest $request): JsonResponse
  {
    return $this->storeService->create($request);
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function list(Request $request): JsonResponse
  {
    return $this->storeService->list($request);
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function publish($id, Request $request): JsonResponse
  {
    return $this->storeService->publish($id, $request);
  }

  /**
   * @param UpdateStoreRequest $request
   * @return JsonResponse
   */
  public function update($id, UpdateStoreRequest $request): JsonResponse
  {
    return $this->storeService->update($id, $request);
  }

}
