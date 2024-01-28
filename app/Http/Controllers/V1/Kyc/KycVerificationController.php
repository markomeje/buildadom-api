<?php

namespace App\Http\Controllers\V1\Kyc;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\V1\Verification\BusinessVerificationService;
use App\Http\Requests\Verification\BusinessVerificationRequest;

class KycVerificationController extends Controller
{

  /**
   * @param BusinessVerificationService $businessVerificationService
   */
  public function __construct(private BusinessVerificationService $businessVerificationService)
  {
    $this->businessVerificationService = $businessVerificationService;
  }

  /**
   *
   * @param BusinessVerificationRequest $request
   * @param JsonResponse
   */
  public function begin(BusinessVerificationRequest $request): JsonResponse
  {
    return $this->businessVerificationService->save($request);
  }

  /**
   *
   * @param JsonResponse
   */
  public function details(): JsonResponse
  {
    return $this->businessVerificationService->details();
  }
}










