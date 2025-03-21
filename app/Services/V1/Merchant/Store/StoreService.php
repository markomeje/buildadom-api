<?php

namespace App\Services\V1\Merchant\Store;
use App\Jobs\UpdateStoreRefJob;
use App\Models\Store\Store;
use App\Services\BaseService;
use App\Traits\V1\StoreTrait;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class StoreService extends BaseService
{
    use StoreTrait;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            UpdateStoreRefJob::dispatch();
            $store_name = $request->name;
            $store = Store::create([
                'name' => ucwords($store_name),
                'slug' => strtolower(str()->slug($store_name)),
                'country_id' => $request->country_id,
                'description' => $request->description,
                'address' => $request->address,
                'city_id' => $request->city_id,
                'state_id' => $request->state_id,
                'user_id' => auth()->id(),
                'published' => false,
                'ref' => $this->generateUniqueStoreRef()
            ]);

            return responser()->send(Status::HTTP_OK, $store, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
        }
    }

    /**
     * @return JsonResponse
     * @param Request $request
     */
    public function list(Request $request): JsonResponse
    {
        try {
            $stores = auth()->user()->stores;
            return responser()->send(Status::HTTP_OK, $stores, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
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
                return responser()->send(Status::HTTP_NOT_FOUND, $store, 'Store record not found. Try again.');
            }

            $store_name = $request->name ?? $store->name;
            $store->update([
                'name' => ucwords($store_name),
                'slug' => strtolower(str()->slug($store_name)),
                'country_id' => $request->country_id,
                'description' => $request->description,
                'address' => $request->address,
                'city_id' => $request->city_id,
                'state_id' => $request->state_id,
            ]);

            return responser()->send(Status::HTTP_OK, $store, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
        }
    }

    /**
     * @param Request $request,
     * @param $id
     */
    public function publish($id, Request $request)
    {
        try {
            $store = Store::owner()->with(['products'])->find($id);
            if(empty($store)) {
                return responser()->send(Status::HTTP_NOT_FOUND, null, 'Store record not found. Try again.');
            }

            $published = (boolean)($request->published ?? 0);
            if(empty($store->banner) || empty($store->logo)) {
                return responser()->send(Status::HTTP_NOT_ACCEPTABLE, null, 'Store banner and logo must be uploaded before publishing a store');
            }

            if(!$store->products()->where('published', 1)->count()) {
                return responser()->send(Status::HTTP_NOT_ACCEPTABLE, null, 'Kindly upload and publish a product first.');
            }

            $store->update(['published' => $published]);
            return responser()->send(Status::HTTP_OK, $store, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
        }
    }

}
