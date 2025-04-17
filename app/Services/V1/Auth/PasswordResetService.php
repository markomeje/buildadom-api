<?php

namespace App\Services\V1\Auth;
use App\Models\Password\PasswordReset;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use App\Services\BaseService;
use App\Utility\Status;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordResetService extends BaseService
{
    /**
     * @throws Exception
     */
    public function initiate(Request $request): JsonResponse
    {
        try {
            $email = $request->email;
            $user = User::where('email', $email)->first();
            if (empty($user)) {
                return responser()->send(Status::HTTP_UNAUTHORIZED, null, 'User not found. Try again.');
            }

            $code = $this->generatePasswordResetCode();
            PasswordReset::create([
                'email' => $email,
                'code' => $code,
                'expiry' => Carbon::now()->addMinutes(5),
            ]);

            $user->notify(new ResetPasswordNotification($code));

            return responser()->send(Status::HTTP_OK, null, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send($e->getCode(), null, $e->getMessage());
        }
    }

    public function reset(Request $request): JsonResponse
    {
        try {
            $reset = PasswordReset::where('code', $request->code)->first();
            if (empty($reset)) {
                return responser()->send(Status::HTTP_UNAUTHORIZED, $reset, 'Invalid password reset code');
            }

            if (Carbon::now() > $reset->expiry) {
                $reset->update(['code' => null]);

                return responser()->send(Status::HTTP_UNAUTHORIZED, $reset, 'Password reset code has expired.');
            }

            $user = User::where('email', $reset->email)->first();
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            $reset->update(['code' => null]);
            PasswordReset::where(['email' => $user->email])->update(['code' => null]);

            return responser()->send(Status::HTTP_OK, $reset, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
        }
    }

    public function confirm(Request $request): JsonResponse
    {
        try {
            $reset = PasswordReset::latest()->where('code', $request->code)->first();
            if (empty($reset)) {
                return responser()->send(Status::HTTP_UNAUTHORIZED, $reset, 'Invalid password reset code');
            }

            return responser()->send(Status::HTTP_OK, $reset, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
        }
    }

    /**
     * @return int
     */
    private function generatePasswordResetCode()
    {
        do {
            $code = rand(11111, 99999);
        } while (PasswordReset::where('code', $code)->exists());

        return (int) $code;
    }
}
