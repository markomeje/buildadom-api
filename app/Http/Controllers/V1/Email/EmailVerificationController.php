<?php

namespace App\Http\Controllers\V1\Email;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Email\EmailVerificationRequest;
use App\Services\V1\Email\EmailVerificationService;
use Illuminate\Http\JsonResponse;

class EmailVerificationController extends Controller
{

  public function __construct(private EmailVerificationService $emailVerification)
  {
    $this->emailVerification = $emailVerification;
  }

  /**
   * Verify phone number
   *
   * @param EmailVerificationRequest $request
   * @param JsonResponse
   */
  public function verify(EmailVerificationRequest $request): JsonResponse
  {
    return $this->emailVerification->verify($request);
  }

  /**
   * Resend email verification code
   *
   * @param JsonResponse
   */
  public function resend(): JsonResponse
  {
    return $this->emailVerification->resend();
  }
}
