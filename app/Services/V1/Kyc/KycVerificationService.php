<?php

namespace App\Services\V1\Kyc;
use App\Enums\Kyc\KycVerificationStatusEnum;
use App\Models\Kyc\KycVerification;
use App\Models\User;
use App\Services\BaseService;
use App\Traits\V1\User\UserTrait;
use App\Utility\Responser;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class KycVerificationService extends BaseService
{
  use UserTrait;

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
      $status = KycVerificationStatusEnum::PENDING->value;
      $kycVerification = KycVerification::updateOrCreate(
        [
          'user_id' => $user_id,
          'status' => $status],
        [
          ...$request->all(),
          'status' => $status,
          'user_id' => $user_id
        ]
      );

      return Responser::send(JsonResponse::HTTP_OK, $kycVerification, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
    }
  }

}
