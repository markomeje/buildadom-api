<?php


namespace App\Services;
use App\Models\Verification;
use Illuminate\Support\Facades\DB as Database;
use App\Notifications\{EmailVerificationNotification, PhoneVerificationNotification};
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
          $user->notify(new PhoneVerificationNotification($code));
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
   * @return response()
   */
  public function generateUniqueCode()
  {
    do {
      $code = random_int(100000, 999999);
    } while (Verification::where(['code' => $code])->first());

    return $code;
  }
	

	/**
	 * 
	 */
	public function update($info): Verification
	{	
		$verification = Verification::find($info->id);
		$verification->code = $info->code;
		$verification->verified = $info->verified ?? false;
		return $verification->update();
	}

	/**
	 * 
	 */
	public function exists($info): ?Verification
	{
		$info = (object)$info;
		return Verification::where([
			'code' => $info->code,
			'type' => $info->type
		])->latest()->first();	
	}

}












