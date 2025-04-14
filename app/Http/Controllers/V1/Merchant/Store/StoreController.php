<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Merchant\Store;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Merchant\Store\CreateStoreRequest;
use App\Http\Requests\V1\Merchant\Store\UpdateStoreRequest;
use App\Services\V1\Merchant\Store\StoreService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Store
     */
    public function __construct(public StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    public function create(CreateStoreRequest $request): JsonResponse
    {
        return $this->storeService->create($request);
    }

    public function list(Request $request): JsonResponse
    {
        return $this->storeService->list($request);
    }

    public function publish($id, Request $request): JsonResponse
    {
        return $this->storeService->publish($id, $request);
    }

    public function update($id, UpdateStoreRequest $request): JsonResponse
    {
        return $this->storeService->update($id, $request);
    }
}
