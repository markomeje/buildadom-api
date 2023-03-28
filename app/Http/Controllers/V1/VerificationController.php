<?php

namespace App\Http\Controllers\V1;
use App\Http\Requests\VerificationRequest;
use App\Actions\SignupAction;
use App\Services\VerificationService;
use App\Notifications\EmailVerificationNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB as Database;
use App\Models\{User, Verification};
use \Exception;


class VerificationController extends Controller
{

  /**
  * Verify email or phone
  * @param json
  */
  public function verify(VerificationRequest $request)
  {
    return Database::transaction(function() use ($request) {
      $type = strtolower($request->type);
      if (!in_array($type, Verification::$types)) {
        return response()->json([
          'success' => false,
          'message' => 'Invalid verification.'
        ]);
      }

      $verification = Verification::where(['code' => $request->code, 'type' => $type])->first();
      if (empty($verification)) {
        return response()->json([
          'success' => false,
          'message' => 'Invalid verification code.'
        ]);
      }

      $verification->code = null;
      $verification->verified = true;
      $verification->update();

      $user = User::find($verification->user_id);
      if($type === 'phone') {
        (new VerificationService())->send(['user' => $user, 'type' => 'email']);
        return response()->json([
          'success' => true,
          'message' => 'An email verification code have been sent to your email.',
        ]);
      }else {
        $token = auth()->login($user);
        return response()->json([
          'success' => true,
          'message' => 'Verification successful.',
          'response' => ['done' => true],
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
        ]);
      }
    });   
  }

}












