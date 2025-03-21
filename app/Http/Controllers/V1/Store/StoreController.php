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
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return $this->storeService->list();
    }

    /**
     * @param string $slug
     * @return JsonResponse
     */
    public function show($slug): JsonResponse
    {
        return $this->storeService->show($slug);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        return $this->storeService->search($request);
    }

}
