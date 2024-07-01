<?php


namespace App\Services\V1\Phone;
use App\Facades\V1\SmsSenderFacade;
use App\Models\Phone\PhoneVerification;
use App\Models\User;
use App\Services\BaseService;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class PhoneVerificationService extends BaseService
{
  /**
   * @return JsonResponse
   */
  public function send(User $user): JsonResponse
  {
    try {
      $code = help()->generateRandomDigits();
      $message = $this->getMessage($code);

      PhoneVerification::create([
        'code' => $code,
        'user_id' => $user->id,
        'expiry' => now()->addMinutes(5),
      ]);

      SmsSenderFacade::push($user, $message);
      return Responser::send(Status::HTTP_CREATED, [], 'Phone verification code has been sent.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

  private function getMessage(int $code): string
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
      $message = $this->getMessage($code);
      $user = User::find(auth()->id());

      $this->createPhoneVerificationDetail($code, $user);
      SmsSenderFacade::push($user, $message);
      return Responser::send(Status::HTTP_CREATED, [], 'Your phone verification code has been resent.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
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
        return Responser::send(Status::HTTP_NOT_ACCEPTABLE, [], 'Invalid phone verification.');
      }

      if($this->phoneIsVerified($phoneVerification)) {
        return Responser::send(Status::HTTP_OK, [], 'Your phone is already verified.');
      }

      if($request->code !== $phoneVerification->code) {
        return Responser::send(Status::HTTP_FORBIDDEN, [], 'Invalid verification code.');
      }

      if($this->phoneVerificationHasExpired($phoneVerification)) {
        return Responser::send(Status::HTTP_FORBIDDEN, [], 'Expired verification code. Request another');
      }

      $phoneVerification->update([
        'code' => null,
        'verified' => true,
        'verified_at' => now()
      ]);

      return Responser::send(Status::HTTP_OK, [$phoneVerification], 'Your phone number has been verified.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

  private function getUserLatestPhoneVerificationDetails(): ?PhoneVerification
  {
    return PhoneVerification::where(['user_id' => auth()->id()])->latest()->first();
  }

  /**
   *
   * @return PhoneVerification
   */
  private function createPhoneVerificationDetail(int $code, User $user)
  {
    return PhoneVerification::create([
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
