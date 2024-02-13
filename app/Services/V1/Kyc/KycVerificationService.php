<?php

namespace App\Services\V1\Kyc;
use App\Enums\Kyc\KycVerificationStatusEnum;
use App\Models\Kyc\KycVerification;
use App\Services\BaseService;
use App\Utility\Responser;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class KycVerificationService extends BaseService
{

  /**
   * Initialize kyc verification
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function initialize(Request $request): JsonResponse
  {
    try {
      $user_id = auth()->id();
      $kycVerification = KycVerification::updateOrCreate(
        ['user_id' => $user_id, 'status' => KycVerificationStatusEnum::PENDING->value],
        [...$request->all(), 'status' => KycVerificationStatusEnum::PENDING->value, 'user_id' => $user_id]
      );

      return Responser::send(JsonResponse::HTTP_OK, $kycVerification, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
    }
  }

  public function info()
  {
    try {
      $kyc_verification = KycVerification::with(['kycFiles'])->where(['user_id' => auth()->id()])->first();
      return Responser::send(JsonResponse::HTTP_OK, $kyc_verification, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
    }
  }

}
