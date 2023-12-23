<?php

namespace App\Http\Controllers\V1\Verification;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\V1\Verification\EmailVerificationService;
use App\Http\Requests\Verification\EmailVerificationRequest;

class EmailVerificationController extends Controller
{

  public function __construct(private EmailVerificationService $emailVerificationService)
  {
    $this->emailVerificationService = $emailVerificationService;
  }

  /**
   * Verify phone number
   *
   * @param EmailVerificationRequest $request
   * @param JsonResponse
   */
  public function verify(EmailVerificationRequest $request): JsonResponse
  {
    return $this->emailVerificationService->verify($request);
  }

  /**
   * Resend phone number verification code
   *
   * @param JsonResponse
   */
  public function resend(): JsonResponse
  {
    return $this->emailVerificationService->resend();
  }
}












