<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
  /**
   * get Logged in user
   * @param $request
   */
  public function me()
  {
    $user = auth()->user();
    if (empty($user)) {
      return response()->json([
        'success' => false,
        'message' => 'Invalid user.',
      ]);
    }

    return response()->json([
      'success' => true,
      'user' => [
        'id' => $user->id, 
        'name' => $user->fullname(), 
        'email' => $user->email, 
        'token' => $token
      ],
      'authorisation' => [
        'token' => $token,
        'type' => 'bearer',
      ],
      'message' => 'User retireved successfully',
    ]);
  }
}