<?php


namespace App\Actions;
use App\Models\Verification;
use App\Notifications\{EmailVerificationNotification};
use App\Services\VerificationService;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Library\Termii;
use Exception;


class SaveVerificationAction
{
  /**
   * Save a verification
   *
   * @return Verification
   * @param User, type
   */
  public static function handle(User $user, string $type = 'phone'): void
  {
    $code = self::code();
    $data = ['type' => $type, 'user_id' => $user->id];
    $verification = Verification::where([...$data, 'verified' => false])->first();
    empty($verification) ? Verification::create([...$data, 'verified' => false, 'code' => $code, 'expiry' => now()->addMinutes(5)]) : $verification->update([...$data, 'code' => $code]);

    strtolower($data['type']) === 'phone' ? Termii::send($user->phone, $code) : $user->notify(new EmailVerificationNotification($code));
  }

  /**
   * Generate random code
   *
   * @return int
   */
  public static function code()
  {
    do {
      $code = random_int(100000, 999999);
    } while (Verification::where(['code' => $code])->first());

    return $code;
  }

}


