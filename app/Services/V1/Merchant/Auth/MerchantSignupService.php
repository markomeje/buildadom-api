<?php

namespace App\Services\V1\Merchant\Auth;
use App\Enums\User\UserRoleEnum;
use App\Enums\User\UserStatusEnum;
use App\Models\User;
use App\Models\UserRole;
use App\Services\BaseService;
use App\Services\V1\Email\EmailVerificationService;
use App\Services\V1\Phone\PhoneVerificationService;
use App\Traits\UserTypeCheckerTrait;
use App\Traits\V1\Business\BusinessProfileTrait;
use App\Utility\Help;
use App\Utility\Responser;
use DB;
use Exception;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


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
      DB::beginTransaction();
      $type = strtolower($request->type);
      $phone = Help::formatPhoneNumber($request->phone);
      $password = Hash::make($request->password);

      $user = User::create([
        'phone' => $phone,
        'email' => $request->email,
        'type' => $type,
        'address' => $request->address,
        'password' => $password ?? null,
        'status' => UserStatusEnum::PENDING->value
      ]);

      $this->createUserBusinessProfile($request, $user);
      if($this->isIndividualUser($user)) {
        $user->update([
          'firstname' => $request->firstname,
          'lastname' => $request->lastname
        ]);
      }

      UserRole::query()->create([
        'name' => UserRoleEnum::MERCHANT->value,
        'user_id' => $user->id
      ]);

      $this->phoneVerification->send($user);
      $this->emailVerification->send($user);

      DB::commit();
      return Responser::send(JsonResponse::HTTP_CREATED, [
        'token' => auth()->login($user),
        'user' => $user
      ], 'Signup successful. Verification detials has been sent.');
    } catch (Exception $e) {
      DB::rollback();
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], 'Oooops! singup failed. Try again.');
    }
  }

}
