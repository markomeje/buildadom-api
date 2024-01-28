<?php


namespace App\Services\V1\Phone;
use Exception;
use App\Models\User;
use App\Utility\Responser;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Http\JsonResponse;
use App\Facades\V1\SmsSenderFacade;
use App\Models\Phone\PhoneVerification;


class PhoneVerificationService extends BaseService
{

  /**
   * @param PhoneVerification $phoneVerification
   * @param User $user
   */
  public function __construct(public PhoneVerification $phoneVerification, private User $user)
  {
    $this->phoneVerification = $phoneVerification;
    $this->user = $user;
  }

  /**
   * @return JsonResponse
   */
  public function send(User $user): JsonResponse
  {
    try {
      $code = $this->generateRandomDigits();
      $message = $this->getPhoneVerificationMessage($code);
      $phoneVerification = $this->createPhoneVerificationDetail($code, $user);

      SmsSenderFacade::push($user, $message);
      return Responser::send(JsonResponse::HTTP_CREATED, [$phoneVerification], 'Phone verification code has been sent.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

  private function getPhoneVerificationMessage(int $code): string
  {
    $sender_id = config('services.termii.sender_id');
    $message = "Your {$sender_id} phone number verification code is {$code}";
    return $message;
  }

  /**
   * @return JsonResponse
   */
  public function resend(): JsonResponse
  {
    try {
      $code = $this->generateRandomDigits();
      $message = $this->getPhoneVerificationMessage($code);
      $user = $this->user->find(auth()->id());

      $this->createPhoneVerificationDetail($code, $user);
      SmsSenderFacade::push($user, $message);
      return Responser::send(JsonResponse::HTTP_CREATED, [], 'Your phone verification code has been resent.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

  public function phoneVerificationHasExpired(PhoneVerification $verification): bool
  {
    return $verification->expiry < now();
  }

  /**
   *
   * @return JsonResponse
   */
  public function verify(Request $request): JsonResponse
  {
    try {
      $phoneVerification = $this->getUserLatestPhoneVerificationDetails();
      if(empty($phoneVerification)) {
        return Responser::send(JsonResponse::HTTP_NOT_ACCEPTABLE, [], 'Invalid phone verification.');
      }

      if($this->phoneIsVerified($phoneVerification)) {
        return Responser::send(JsonResponse::HTTP_OK, [], 'Your phone is already verified.');
      }

      if($request->code !== $phoneVerification->code) {
        return Responser::send(JsonResponse::HTTP_FORBIDDEN, [], 'Invalid verification code.');
      }

      if($this->phoneVerificationHasExpired($phoneVerification)) {
        return Responser::send(JsonResponse::HTTP_FORBIDDEN, [], 'Expired verification code. Request another');
      }

      $phoneVerification->update([
        'code' => null,
        'verified' => true,
        'verified_at' => now()
      ]);

      return Responser::send(JsonResponse::HTTP_OK, [$phoneVerification], 'Your phone number has been verified.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

  private function getUserLatestPhoneVerificationDetails(): ?PhoneVerification
  {
    return $this->phoneVerification->where(['user_id' => auth()->id()])->latest()->first();
  }

  /**
   *
   * @return PhoneVerification
   */
  private function createPhoneVerificationDetail(int $code, User $user)
  {
    return $this->phoneVerification->create([
      'code' => $code,
      'user_id' => $user->id,
      'expiry' => now()->addMinutes(5),
    ]);
  }

  public function phoneIsVerified(PhoneVerification $phoneVerification): bool
  {
    return (bool)$phoneVerification->verified === true;
  }

}












