<?php

namespace App\Http\Controllers\V1;
use App\Http\Requests\VerificationRequest;
use App\Http\Requests\ResendCodeRequest;
use App\Services\VerificationService;
use App\Http\Controllers\Controller;
use Exception;


class VerificationController extends Controller
{

  /**
  * Verify email or phone
  * @param json
  */
  public function verify(VerificationRequest $request)
  {
    try {
      if($verification = (new VerificationService())->verify($request->validated())) {
        return $verification;
      }

      return response()->json([
        'success' => false,
        'message' => 'Invalid verification.'
      ], 500);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage(),
      ], 500);
    }
  }

  /**
  * Verify email or phone
  * @param json
  */
  public function resend(ResendCodeRequest $request)
  {
    try {
      if($verification = VerificationService::resend($request->validated())) {
        return $verification;
      }

      return response()->json([
        'success' => false,
        'message' => 'Invalid verification.'
      ], 500);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage(),
      ], 500);
    }
  }

}












