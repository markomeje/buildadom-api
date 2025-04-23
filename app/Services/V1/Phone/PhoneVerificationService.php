<?php

namespace App\Services\V1\Phone;
use App\Jobs\SmsSenderJob;
use App\Models\Phone\PhoneVerification;
use App\Models\User;
use App\Partners\TermiiSmsProvider;
use App\Services\BaseService;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PhoneVerificationService extends BaseService
{
    /**
     * Expiry in minutes
     *
     * @var int
     */
    private $expiry = 20;

    /**
     * @param \App\Models\User $user
     * @return JsonResponse
     */
    public function send(User $user): JsonResponse
    {
        try {
            $code = help()->generateRandomDigits(6);
            $message = $this->getMessage($code);

            $this->createPhoneVerificationDetail($code, $user);
            SmsSenderJob::dispatch(new TermiiSmsProvider(), $user->phone, $message, $user);

            return responser()->send(Status::HTTP_CREATED, null, 'Phone verification code has been sent.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
        }
    }

    /**
     * @return JsonResponse
     */
    public function resend(): JsonResponse
    {
        try {
            $code = help()->generateRandomDigits(6);
            $message = $this->getMessage($code);
            $user = User::find(auth()->id());

            $this->createPhoneVerificationDetail($code, $user);
            SmsSenderJob::dispatch(new TermiiSmsProvider(), $user->phone, $message, $user);

            return responser()->send(Status::HTTP_CREATED, null, 'Your phone verification code has been resent.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
        }
    }

    /**
     * @param \App\Models\Phone\PhoneVerification $verification
     * @return bool
     */
    public function phoneVerificationHasExpired(PhoneVerification $verification): bool
    {
        return $verification->expiry < now();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function verify(Request $request): JsonResponse
    {
        try {
            $phoneVerification = $this->getUserLatestPhoneVerificationDetails();
            if (empty($phoneVerification)) {
                return responser()->send(Status::HTTP_NOT_ACCEPTABLE, null, 'Invalid phone verification.');
            }

            if ($this->phoneIsVerified($phoneVerification)) {
                return responser()->send(Status::HTTP_OK, null, 'Your phone is already verified.');
            }

            if ($request->code !== $phoneVerification->code) {
                return responser()->send(Status::HTTP_FORBIDDEN, null, 'Invalid verification code.');
            }

            if ($this->phoneVerificationHasExpired($phoneVerification)) {
                return responser()->send(Status::HTTP_FORBIDDEN, null, 'Expired verification code. Request another');
            }

            $phoneVerification->update([
                'code' => null,
                'verified' => true,
                'verified_at' => now(),
            ]);

            return responser()->send(Status::HTTP_OK, [$phoneVerification], 'Your phone number has been verified.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
        }
    }

    /**
     * @param \App\Models\Phone\PhoneVerification $phoneVerification
     * @return bool
     */
    public function phoneIsVerified(PhoneVerification $phoneVerification): bool
    {
        return (bool) $phoneVerification->verified === true;
    }

    /**
     * @param int $code
     * @return string
     */
    private function getMessage(int $code): string
    {
        $sender_id = config('services.termii.sender_id');
        $message = "Your {$sender_id} phone number verification code is {$code}";
        return $message;
    }

    /**
     * @return object|PhoneVerification|\Illuminate\Database\Eloquent\Model|null
     */
    private function getUserLatestPhoneVerificationDetails(): ?PhoneVerification
    {
        return PhoneVerification::where(['user_id' => auth()->id()])->latest()->first();
    }

    /**
     * @param int $code
     * @param \App\Models\User $user
     * @return PhoneVerification|\Illuminate\Database\Eloquent\Model
     */
    private function createPhoneVerificationDetail(int $code, User $user)
    {
        return PhoneVerification::create([
            'code' => $code,
            'user_id' => $user->id,
            'expiry' => now()->addMinutes($this->expiry),
        ]);
    }
}
