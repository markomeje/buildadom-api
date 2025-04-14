<?php

declare(strict_types=1);

namespace App\Services\V1\Store;
use App\Models\Store\Store;
use App\Services\BaseService;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreService extends BaseService
{
    public function list(): JsonResponse
    {
        try {
            $stores = Store::published()->with(['state', 'city'])->latest()->get();

            return responser()->send(Status::HTTP_OK, $stores, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
        }
    }

    public function show(string $slug): JsonResponse
    {
        try {
            $store = Store::published()->with(['state', 'city'])->where('slug', $slug)->first();

            return responser()->send(Status::HTTP_OK, $store, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, 'Operation failed. Try again.');
        }
    }

    public function search(Request $request): JsonResponse
    {
        try {
            $search = $request->get('query');
            $stores = Store::with(['state', 'city'])->published()
                ->where(function ($query) use ($search)
                {
                    $query->orWhere('name', 'LIKE', "%{$search}%")
                        ->orWhere('address', 'LIKE', "%{$search}%")
                        ->whereHas('state', function ($query) use ($search)
                        {
                            $query->orWhere('name', 'LIKE', "%{$search}%");
                        })
                        ->whereHas('city', function ($query) use ($search)
                        {
                            $query->orWhere('name', 'LIKE', "%{$search}%");
                        });
                })
                ->get();

            return responser()->send(Status::HTTP_OK, $stores, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
        }
    }
}
