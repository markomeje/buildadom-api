<?php

namespace App\Services\V1\Admin\Kyc;
use App\Enums\Kyc\KycVerificationStatusEnum;
use App\Models\Kyc\KycVerification;
use App\Notifications\Admin\AdminKycActionNotification;
use App\Services\BaseService;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class KycVerificationService extends BaseService
{

  /**
   * Admin action on a KYC verification
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function action($id, Request $request): JsonResponse
  {
    try {
      $kyc_verification = KycVerification::with(['kycFiles'])->find($id);
      if(empty($kyc_verification)) {
        return Responser::send(Status::HTTP_NOT_FOUND, null, 'Invalid Kyc verification record.');
      }

      $kyc_status = strtolower($request->status);
      $allowed_status = [
        KycVerificationStatusEnum::INVALID->value,
        KycVerificationStatusEnum::VERIFIED->value,
        KycVerificationStatusEnum::FAILED->value
      ];

      if(!in_array($kyc_status, $allowed_status)) {
        return Responser::send(Status::HTTP_NOT_FOUND, null, 'Invalid Kyc verification status');
      }

      $kyc_verification->update(['status' => $kyc_status]);

      $kyc_verification->user->notify(new AdminKycActionNotification($kyc_status));
      return Responser::send(Status::HTTP_OK, $kyc_verification, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, null, 'Operation failed. Try again.');
    }
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function list(Request $request): JsonResponse
  {
    try {
      $kyc_verifications = KycVerification::with(['kycFiles'])->paginate($request->limit ?? 20);
      return Responser::send(Status::HTTP_OK, $kyc_verifications, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
    }
  }

}
