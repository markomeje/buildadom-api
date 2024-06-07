<?php

namespace App\Http\Controllers\V1\Store;
use App\Http\Controllers\Controller;
use App\Services\V1\Store\StoreService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreController extends Controller
{
  /**
   * @param StoreService $StoreService
   */
  public function __construct(private StoreService $storeService)
  {
    $this->storeService = $storeService;
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
   * @param int $id
   * @return JsonResponse
   */
  public function show($id): JsonResponse
  {
    return $this->storeService->show($id);
  }
}
