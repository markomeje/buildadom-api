<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\{User, Verification};
use App\Actions\SaveVerificationAction;


class AuthController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth:api', ['except' => ['login']]);
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

    foreach (['phone', 'email'] as $type) {
      $verification = Verification::where(['type' => $type, 'user_id' => $user->id])->first();
      if ((boolean)($verification->verified ?? false) !== true) {
        SaveVerificationAction::handle($user, $type);
        return response()->json([
          'success' => false,
          'message' => "A verification code have been sent to your {$type}.",
          'verification' => ['type' => $type, 'verified' => false],
        ], 401);
      }
    }

    $token = auth()->attempt($request->validated());
    if (!$token) {
      return response()->json([
        'success' => false,
        'message' => 'Invalid login details.',
      ], 401);
    }

    $user = auth()->user();
    $name = strtolower($user->type) === 'individual' ? $user->fullname() : ($user->business ? $user->business->name : null);
    return response()->json([
      'success' => true,
      'response' => [
        'user' => ['id' => $user->id, 'name' => $name, 'email' => $user->email, 'token' => $token]
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


