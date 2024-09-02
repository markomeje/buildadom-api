<?php

namespace App\Services\V1\Fee;
use App\Models\Fee\FeeSetting;
use App\Services\BaseService;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;


class FeeSettingSeeder extends BaseService
{
  /**
   * @return JsonResponse
   */
  public function list(): JsonResponse
  {
    try {
      $fees = FeeSetting::latest()->get();
      return responser()->send(Status::HTTP_OK, $fees, 'Operation successful.');
    } catch (Exception $e) {
      return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
    }
  }

}
