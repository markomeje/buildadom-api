<?php

namespace App\Services\V1\Admin\Fee;
use App\Models\Fee\FeeSetting;
use App\Services\BaseService;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FeeSettingService extends BaseService
{
    public function list(Request $request): JsonResponse
    {
        try {
            $fees = FeeSetting::latest()->paginate($request->limit ?? 20);

            return responser()->send(Status::HTTP_OK, $fees, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
        }
    }
}
