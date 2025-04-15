<?php

namespace App\Services\V1\Customer\Auth;
use App\Enums\User\UserRoleEnum;
use App\Enums\User\UserStatusEnum;
use App\Enums\User\UserTypeEnum;
use App\Models\User;
use App\Models\UserRole;
use App\Services\BaseService;
use App\Services\V1\Email\EmailVerificationService;
use App\Services\V1\Phone\PhoneVerificationService;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerSignupService extends BaseService
{
    public function signup(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'phone' => formatPhoneNumber($request->phone),
                'email' => $request->email,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'type' => UserTypeEnum::INDIVIDUAL->value,
                'address' => $request->address,
                'password' => Hash::make($request->password),
                'status' => UserStatusEnum::PENDING->value,
            ]);

            UserRole::create([
                'name' => UserRoleEnum::CUSTOMER->value,
                'user_id' => $user->id,
            ]);

            (new PhoneVerificationService)->send($user);
            (new EmailVerificationService)->send($user);

            DB::commit();

            return responser()->send(Status::HTTP_CREATED, ['token' => auth()->login($user), 'user' => $user], 'Signup successful. Verification detials has been sent.');
        } catch (Exception) {
            DB::rollback();

            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Oooops! singup failed. Try again.');
        }
    }
}
