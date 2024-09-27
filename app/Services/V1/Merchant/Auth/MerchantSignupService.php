<?php

namespace App\Services\V1\Merchant\Auth;
use App\Enums\User\UserRoleEnum;
use App\Enums\User\UserStatusEnum;
use App\Models\User;
use App\Models\UserRole;
use App\Services\BaseService;
use App\Services\V1\Email\EmailVerificationService;
use App\Services\V1\Phone\PhoneVerificationService;
use App\Traits\V1\UserTypeCheckerTrait;
use App\Traits\V1\BusinessProfileTrait;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class MerchantSignupService extends BaseService
{

  use UserTypeCheckerTrait, BusinessProfileTrait;

  public function __construct(private PhoneVerificationService $phoneVerification, private EmailVerificationService $emailVerification)
  {
    $this->phoneVerification = $phoneVerification;
    $this->emailVerification = $emailVerification;
  }

  /**
   * Signup merchant
   * @param Request $request
   *
   * @return JsonResponse
   */
  public function signup(Request $request): JsonResponse
  {
    try {
      $user = User::create([
        'phone' => formatPhoneNumber($request->phone),
        'email' => $request->email,
        'type' => strtolower($request->type),
        'address' => $request->address,
        'password' => Hash::make($request->password) ?? null,
        'status' => UserStatusEnum::PENDING->value,
        'firstname' => $request->firstname ?? null,
        'lastname' => $request->lastname ?? null
      ]);

      $this->createUserBusinessProfile($request, $user);
      UserRole::create([
        'name' => UserRoleEnum::MERCHANT->value,
        'user_id' => $user->id
      ]);

      (new PhoneVerificationService())->send($user);
      (new EmailVerificationService())->send($user);

      return responser()->send(Status::HTTP_CREATED, ['token' => auth()->login($user), 'user' => $user], 'Signup successful. Verification detials has been sent.');
    } catch (Exception $e) {
      return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Oooops! singup failed. Try again.');
    }
  }

}
