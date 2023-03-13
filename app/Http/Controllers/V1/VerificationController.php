<?php

namespace App\Http\Controllers\V1;
use App\Http\Requests\VerificationRequest;
use App\Actions\SignupAction;
use App\Services\VerificationService;
use App\Http\Controllers\Controller;
use \Exception;


class VerificationController extends Controller
{
  /**
   * Create waiting list
   * @param $request $signup
   */
  public function phone(VerificationRequest $request, VerificationService $verification)
  {
    try {
      $type = $request->type;
      $verify = $verification->exists([
        'type' => $type,
        'code' => $request->code
      ]);

      if (empty($verify)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid verification code.'
        ]);
      }

      if ($verification->verified($verify->verified)) {
        return response()->json([
            'success' => true,
            'message' => "Your {$type} is verified",
        ]);
      }

      $updated = $verify->update([
        'id' => $verify->id,
        'code' => null, 
        'verified' => true
      ]);

      if ($updated) {
        return response()->json([
            'success' => true,
            'message' => "Your {$type} is verified",
        ]);

        $verify->user($type)->notify(new EmailVerificationNotification($token));
      }

      return response()->json([
        'success' => false,
        'message' => 'Operation failed'
      ]);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage(),
      ]);
    }    
  }
}
