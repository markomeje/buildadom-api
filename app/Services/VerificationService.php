<?php


namespace App\Services;
use App\Models\{Verification, User};
use Illuminate\Support\Facades\DB;
use App\Notifications\{EmailVerificationNotification};
use App\Library\Termii;
use App\Actions\SaveVerificationAction;
use Exception;


class VerificationService
{

  /**
   * Verify user by type
   *
   * @param array type
   */
  public function verify(array $data)
  {
    return DB::transaction(function() use ($data) {
      $type = strtolower($data['type']);
      $verification = Verification::where([...$data, 'verified' => false])->first();
      if (empty($verification)) {
        return response()->json([
          'success' => false,
          'message' => 'Invalid verification code.'
        ], 403);
      }

      $verification->update(['code' => null, 'verified' => true]);
      $user = User::find($verification->user_id);
      if($type === 'phone') {
        SaveVerificationAction::handle($user, 'email');
        return response()->json([
          'success' => true,
          'message' => 'A verification code have been sent to your email.'
        ], 200);
      }

      return response()->json([
        'success' => true,
        'message' => 'Operation successful.',
        'response' => ['done' => true],
        'user' => ['id' => $user->id, 'name' => $user->fullname(), 'email' => $user->email, 'token' => auth()->login($user)]
      ], 200);

    });
  }

  /**
   * Verify user by type
   *
   * @param array type
   */
  public function resend(array $data)
  {
    return DB::transaction(function() use ($data) {
      $type = strtolower($data['type']);
      $verification = Verification::where([...$data, 'verified' => false])->first();
      if (empty($verification)) {
        return response()->json(['success' => false, 'message' => 'Invalid verification code.'], 403);
      }

      $verification->update(['code' => null, 'verified' => true]);
      $user = User::find($verification->user_id);
      if($type === 'phone') {
        SaveVerificationAction::handle($user, 'email');
        return response()->json(['success' => true, 'message' => 'An email verification code have been sent to your email.'], 200);
      }

      return response()->json(['success' => true, 'message' => 'Operation successful.', 'response' => ['done' => true], 'user' => ['id' => $user->id, 'name' => $user->fullname(), 'email' => $user->email, 'token' => auth()->login($user)]], 200);

    });
  }

}












