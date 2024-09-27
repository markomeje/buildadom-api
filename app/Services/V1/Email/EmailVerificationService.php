<?php


namespace App\Services\V1\Email;
use App\Models\Email\EmailVerification;
use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use App\Services\BaseService;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Ideally, all services must return a json response when called in the controller
 *
 */
class EmailVerificationService extends BaseService
{

  /**
   * Expiry in minutes
   * @var int
   */
  private $expiry = 20;

  /**
   * @return JsonResponse
   */
  public function send(User $user): JsonResponse
  {
    try {
      $code = help()->generateRandomDigits(6);
      $emailVerification = $this->saveVerificationDetail($code, $user);

      $user->notify(new EmailVerificationNotification($code));
      return responser()->send(Status::HTTP_CREATED, [$emailVerification], 'Email verification code has been sent.');
    } catch (Exception $e) {
      return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

  /**
   * @return JsonResponse
   */
  public function resend(): JsonResponse
  {
    try {
      $code = help()->generateRandomDigits(6);
      $user = User::find(auth()->id());

      $emailVerification = $this->getVerificationDetails();
      if(!empty($emailVerification)) {
        if($this->isVerified($emailVerification)) {
          return responser()->send(Status::HTTP_OK, [], 'Your email is already verified.');
        }
      }

      $this->saveVerificationDetail($code, $user);
      $user->notify(new EmailVerificationNotification($code));
      return responser()->send(Status::HTTP_CREATED, [], 'Your email verification code has been resent.');
    } catch (Exception $e) {
      return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

  public function verificationExpired(EmailVerification $emailVerification): bool
  {
    return $emailVerification->expiry < now();
  }

  /**
   *
   * @return JsonResponse
   */
  public function verify(Request $request): JsonResponse
  {
    try {
      $emailVerification = $this->getVerificationDetails();
      if(empty($emailVerification)) {
        return responser()->send(Status::HTTP_NOT_ACCEPTABLE, [], 'Invalid email verification.');
      }

      if($this->isVerified($emailVerification)) {
        return responser()->send(Status::HTTP_OK, [], 'Your email is already verified.');
      }

      if($request->code !== $emailVerification->code) {
        return responser()->send(Status::HTTP_FORBIDDEN, [], 'Invalid verification code.');
      }

      if($this->verificationExpired($emailVerification)) {
        return responser()->send(Status::HTTP_FORBIDDEN, [], 'Expired verification code. Request another');
      }

      $emailVerification->update([
        'code' => null,
        'verified' => true,
        'verified_at' => now()
      ]);

      return responser()->send(Status::HTTP_OK, [$emailVerification], 'Your email has been verified.');
    } catch (Exception $e) {
      return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

  /**
   * @return EmailVerification|object
   */
  private function getVerificationDetails(): ?emailVerification
  {
    return EmailVerification::where(['user_id' => auth()->id()])->latest()->first();
  }

  /**
   * Save email verification detail
   *
   * @param int $code
   * @param User $user
   *
   * @return mixed
   */
  private function saveVerificationDetail(int $code, User $user)
  {
    $emailVerificationDetails = $this->getVerificationDetails();
    $expiry = now()->addMinutes($this->expiry);

    if(empty($emailVerificationDetails)) {
      return EmailVerification::create([
        'code' => $code,
        'user_id' => $user->id,
        'expiry' => $expiry,
      ]);
    }

    return $emailVerificationDetails->update([
      'code' => $code,
      'expiry' => $expiry,
      'verified' => false,
    ]);
  }

  /**
   * @param EmailVerification $emailVerification
   * @return bool
   */
  public function isVerified(EmailVerification $emailVerification): bool
  {
    return (bool)$emailVerification->verified === true;
  }

}
