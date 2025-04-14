<?php

namespace App\Services\V1\Merchant\Store;
use App\Models\Store\Store;
use App\Services\BaseService;
use App\Traits\FileUploadTrait;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class StoreUploadService extends BaseService
{
    use FileUploadTrait;

    /**
     * @param int $store_id,
     * @param Request $request
     * @return JsonResponse
     */
    public function logo($store_id, Request $request): JsonResponse
    {
        try {
            $store = Store::find($store_id);
            if(empty($store)) {
                return responser()->send(Status::HTTP_NOT_FOUND, $store, 'Store record not found. Try again.');
            }

            $file = $request->file('logo');
            $logo_url = $this->uploadToS3($file, $store->logo);

            $store->update(['logo' => $logo_url]);
            return responser()->send(Status::HTTP_OK, $store, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
        }
    }

    /**
     * @param int $store_id,
     * @param Request $request
     * @return JsonResponse
     */
    public function banner($store_id, Request $request)
    {
        try {
            $store = Store::find($store_id);
            if(empty($store)) {
                return responser()->send(Status::HTTP_NOT_FOUND, $store, 'Store record not found. Try again.');
            }

            $file = $request->file('banner');
            $banner_url = $this->uploadToS3($file, $store->banner);

            $store->update(['banner' => $banner_url]);
            return responser()->send(Status::HTTP_OK, $store, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
        }
    }

}
