<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Models\Image;


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

    $user = auth()->user();
    $name = strtolower($user->type) === 'individual' ? $user->fullname() : ($user->business ? $user->business->name : null);
    return response()->json([
       'success' => true,
       'response' => [
         'user' => [
            'id' => $user->id,
            'name' => $name,
            'email' => $user->email,
            'profile_pic' => Image::where(['model_id' => auth()->id(), 'model' => 'profile'])->first(),
            'address' => $user->address,
            'type' => $user->type,
          ]
        ],
       'message' => 'Operation successful',
    ], 200);
  }
}
