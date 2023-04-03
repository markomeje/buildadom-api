<?php

namespace App\Http\Controllers\V1;
use App\Http\Requests\SignupRequest;
use App\Services\SignupService;
use App\Http\Controllers\Controller;
use \Exception;


class SignupController extends Controller
{
  /**
   * Signup user
   * @param $request $signup
   */
  public function signup(SignupRequest $request)
  {
    try {
      (new SignupService())->signup($request->validated());
      return response()->json([
        'success' => true,
        'message' => 'Signup successful. A verification code have been sent to your phone number.',
      ], 201);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage(),
      ], 500);
    }
          
  }
}
