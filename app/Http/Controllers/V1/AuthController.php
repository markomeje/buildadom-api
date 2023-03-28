<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\{User, Verification};
use App\Services\VerificationService;


class AuthController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth:api', [
      'except' => ['login']
    ]);
  }

  /**
   * Login
   * @param $request
   */
  public function login(LoginRequest $request)
  {
    $user = User::where(['email' => $request->email])->first();
    if (empty($user)) {
      return response()->json([
        'success' => false,
        'message' => 'Invalid account details.',
      ], 401);
    }

    $verification = Verification::where(['user_id' => $user->id, 'type' => 'phone'])->first();
    if (empty($verification) || (boolean)($verification->verified ?? false) !== true) {
      (new VerificationService())->send(['user' => $user, 'type' => 'phone']);
      return response()->json([
        'success' => false,
        'message' => 'A verification code have been sent to your phone number.',
        'verification' => ['verified' => false, 'type' => 'phone']
      ], 401);
    }

    $verification = Verification::where(['user_id' => $user->id, 'type' => 'email'])->first();
    if (empty($verification) || (boolean)($verification->verified ?? false) !== true) {
      (new VerificationService())->send(['user' => $user, 'type' => 'email']);
      return response()->json([
        'success' => false,
        'message' => 'A verification code have been sent to your email.',
        'verification' => ['verified' => false, 'type' => 'email']
      ], 401);
    }

    $token = auth()->attempt($request->validated());
    if (!$token) {
      return response()->json([
        'success' => false,
        'message' => 'Invalid login details.',
      ], 401);
    }

    $user = auth()->user();
    return response()->json([
      'success' => true,
      'response' => [
        'user' => [
          'id' => $user->id, 
          'name' => $user->fullname(), 
          'email' => $user->email, 
          'token' => $token
        ]
      ],
      'message' => 'Login successful',
    ], 200);
  }

  public function logout()
  {
    auth()->logout();
    return response()->json([
      'success' => true,
      'message' => 'Successfully logged out',
    ]);
  }

  /**
   * Refresh user token
   */
  public function refresh()
  {
    $user = auth()->user();
    return response()->json([
      'success' => true,
      'response' => [
        'user' => [
          'id' => $user->id, 
          'name' => $user->fullname(), 
          'email' => $user->email, 
          'token' => auth()->refresh()
        ],
      ],
      'message' => 'Token refreshed',
    ]);
  }
}


