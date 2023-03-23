<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;


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
    $token = auth()->attempt($request->validated());
    if (!$token) {
      return response()->json([
        'success' => false,
        'message' => 'Invalid login details.',
      ]);
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
        ],
        'authorisation' => [
          'token' => $token,
          'type' => 'bearer',
        ]
      ],
      'message' => 'Login successful',
    ]);
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
          'token' => $token
        ],
    
        'authorisation' => [
          'token' => auth()->refresh(),
          'type' => 'bearer',
        ]
      ],
      'message' => 'Token refreshed',
    ]);
  }
}


