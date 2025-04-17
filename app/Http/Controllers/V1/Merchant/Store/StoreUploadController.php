<?php

namespace App\Http\Controllers\V1\Merchant\Store;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Merchant\Store\UploadStoreBannerRequest;
use App\Http\Requests\V1\Merchant\Store\UploadStoreLogoRequest;
use App\Services\V1\Merchant\Store\StoreUploadService;
use Illuminate\Http\JsonResponse;

class StoreUploadController extends Controller
{
    /**
     * Store
     */
    public function __construct(public StoreUploadService $storeUploadService)
    {
        $this->storeUploadService = $storeUploadService;
    }

    public function logo($store_id, UploadStoreLogoRequest $request): JsonResponse
    {
        return $this->storeUploadService->logo($store_id, $request);
    }

    public function banner($store_id, UploadStoreBannerRequest $request): JsonResponse
    {
        return $this->storeUploadService->banner($store_id, $request);
    }
}
