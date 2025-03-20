<?php

namespace App\Services\V1\Fee;
use App\Models\Fee\FeeSetting;
use App\Services\BaseService;
use App\Utility\Status;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class FeeSettingService extends BaseService
{
    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        try {
            $fees = FeeSetting::latest()->get();
            return responser()->send(Status::HTTP_OK, $fees, 'Fee settings fetched successfully.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, 'Fetching fee settings failed. Try again.');
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        try {
            $fee = FeeSetting::where('code', $request->code)->firstOrFail();
            return responser()->send(Status::HTTP_OK, $fee, 'Fee setting fetched successfully.');
        } catch(ModelNotFoundException $m) {
            return responser()->send(Status::HTTP_NOT_FOUND, null, 'Invalid fee code.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, 'Fetching fee setting failed. Try again.');
        }
    }

}
