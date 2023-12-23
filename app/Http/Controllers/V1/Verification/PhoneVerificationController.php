<?php

namespace App\Http\Controllers\V1\Verification;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\V1\Verification\PhoneVerificationService;
use App\Http\Requests\Verification\PhoneVerificationRequest;

class PhoneVerificationController extends Controller
{

  public function __construct(private PhoneVerificationService $phoneVerificationService)
  {
    $this->phoneVerificationService = $phoneVerificationService;
  }

  /**
   * Verify phone number
   *
   * @param PhoneVerificationRequest $request
   * @param JsonResponse
   */
  public function verify(PhoneVerificationRequest $request): JsonResponse
  {
    return $this->phoneVerificationService->verify($request);
  }

  /**
   * Resend phone number verification code
   *
   * @param JsonResponse
   */
  public function resend(): JsonResponse
  {
    return $this->phoneVerificationService->resend();
  }
}












