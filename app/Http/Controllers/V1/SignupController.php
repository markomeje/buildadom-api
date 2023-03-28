<?php

namespace App\Http\Controllers\V1;
use App\Http\Requests\SignupRequest;
use App\Actions\SignupAction;
use App\Http\Controllers\Controller;
use \Exception;


class SignupController extends Controller
{
  /**
   * Create waiting list
   * @param $request $signup
   */
  public function signup(SignupRequest $request, SignupAction $signup)
  {
    try {
      if($signup->handle($request->validated())) {
        return response()->json([
          'success' => true,
          'message' => 'Signup successful. A verification code have been sent to your phone number.',
        ], 201);
      }

      return response()->json([
        'success' => false,
        'message' => 'Operation failed. Try again'
      ], 500);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage(),
      ], 500);
    }
          
  }
}
