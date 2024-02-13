<?php

namespace App\Http\Controllers\V1\Kyc;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Kyc\InitializeKycVerificationRequest;
use App\Services\V1\Kyc\KycVerificationService;
use Illuminate\Http\JsonResponse;

class KycVerificationController extends Controller
{

  /**
   * @param KycVerificationService $kycVerification
   */
  public function __construct(private KycVerificationService $kycVerification)
  {
    $this->kycVerification = $kycVerification;
  }

  /**
   *
   * @param InitializeKycVerificationRequest $request
   * @param JsonResponse
   */
  public function initialize(InitializeKycVerificationRequest $request): JsonResponse
  {
    return $this->kycVerification->initialize($request);
  }

  /**
   *
   * @param JsonResponse
   */
  public function info(): JsonResponse
  {
    return $this->kycVerification->info();
  }
}
