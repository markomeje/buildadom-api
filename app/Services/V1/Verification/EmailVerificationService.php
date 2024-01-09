<?php


namespace App\Services\V1\Verification;
use Exception;
use App\Models\User;
use App\Utility\Responser;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Http\JsonResponse;
use App\Facades\V1\SmsSenderFacade;
use App\Models\Verification\emailVerification;
use App\Notifications\EmailVerificationNotification;

/**
 * Ideally, all services must return a json response when called in the controller
 *
 */
class EmailVerificationService extends BaseService
{

  /**
   * @param EmailVerification $emailVerification
   * @param User $user
   */
  public function __construct(public EmailVerification $emailVerification, private User $user)
  {
    $this->emailVerification = $emailVerification;
    $this->user = $user;
  }

  /**
   * @return JsonResponse
   */
  public function send(User $user): JsonResponse
  {
    try {
      $code = $this->generateRandomDigits();
      $emailVerification = $this->saveVerificationDetail($code, $user);

      $user->notify(new EmailVerificationNotification($code));
      return Responser::send(JsonResponse::HTTP_CREATED, [$emailVerification], 'Email verification code has been sent.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

  /**
   * @return JsonResponse
   */
  public function resend(): JsonResponse
  {
    try {
      $code = $this->generateRandomDigits();
      $user = $this->user->find(auth()->id());

      $emailVerification = $this->getVerificationDetails();
      if(!empty($emailVerification)) {
        if($this->isVerified($emailVerification)) {
          return Responser::send(JsonResponse::HTTP_OK, [], 'Your email is already verified.');
        }
      }

      $this->saveVerificationDetail($code, $user);
      $user->notify(new EmailVerificationNotification($code));
      return Responser::send(JsonResponse::HTTP_CREATED, [], 'Your email verification code has been resent.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
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
        return Responser::send(JsonResponse::HTTP_NOT_ACCEPTABLE, [], 'Invalid email verification.');
      }

      if($this->isVerified($emailVerification)) {
        return Responser::send(JsonResponse::HTTP_OK, [], 'Your email is already verified.');
      }

      if($request->code !== $emailVerification->code) {
        return Responser::send(JsonResponse::HTTP_FORBIDDEN, [], 'Invalid verification code.');
      }

      if($this->verificationExpired($emailVerification)) {
        return Responser::send(JsonResponse::HTTP_FORBIDDEN, [], 'Expired verification code. Request another');
      }

      $emailVerification->update([
        'code' => null,
        'verified' => true,
        'verified_at' => now()
      ]);

      return Responser::send(JsonResponse::HTTP_OK, [$emailVerification], 'Your email has been verified.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

  private function getVerificationDetails(): ?emailVerification
  {
    return $this->emailVerification->where(['user_id' => auth()->id()])->first();
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
    $expiry = now()->addMinutes(5);

    if(empty($emailVerificationDetails)) {
      return $this->emailVerification->create([
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

  public function isVerified(EmailVerification $emailVerification): bool
  {
    return (bool)$emailVerification->verified === true;
  }

}












