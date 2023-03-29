<?php


namespace App\Services;
use App\Models\Verification;
use Illuminate\Support\Facades\DB as Database;
use App\Notifications\{EmailVerificationNotification, PhoneVerificationNotification};
use App\Library\Termii;
use Exception;


class VerificationService
{

  /**
   * Send a verification code
   * 
   * @return Verification model
   * @param info containung the verification code and type
   * @types 'phone' || 'email'
   */
  public function send($data): Verification
  {
    return Database::transaction(function() use ($data) {
      $type = strtolower($data['type'] ?? '');
      if (!in_array($type, Verification::$types)) {
        throw new Exception('Invalid verification type passed');
      }

      $user = $data['user'];
      $code = $this->generateUniqueCode();
      Verification::where(['user_id' => $user->id, 'type' => $type])->delete();

      $verification = Verification::create([ 
        'code' => $code,
        'expiry' => now()->addMinutes(10),
        'type' => $type,
        'user_id' => $user->id,
        'verified' => false,
      ]);

      switch ($type) {
        case 'phone':
          //$user->notify(new PhoneVerificationNotification($code));
          Termii::sms(['message' => $code, 'phone' => $user->phone])->send();
          break;
        case 'email':
          $user->notify(new EmailVerificationNotification($code));
          break;
        default:
          throw new Exception('Invalid verification type passed');
          break;
      }

      return $verification;

    });
    
  }

  /**
   * Write code on Method
   *
   * @return int
   */
  public function generateUniqueCode()
  {
    do {
      $code = random_int(100000, 999999);
    } while (Verification::where(['code' => $code])->first());

    return $code;
  }

}












