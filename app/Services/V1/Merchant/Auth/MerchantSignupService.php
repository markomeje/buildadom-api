<?php


namespace App\Services\V1\Merchant\Auth;
use DB;
use Hash;
use Exception;
use App\Models\User;
use App\Models\UserRole;
use App\Utility\Responser;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Helpers\UtilityHelper;
use App\Enums\User\UserRoleEnum;
use Illuminate\Http\JsonResponse;
use App\Enums\User\UserStatusEnum;
use App\Traits\UserTypeCheckerTrait;
use App\Traits\V1\Business\BusinessProfileTrait;
use App\Notifications\EmailVerificationNotification;
use App\Services\V1\Verification\EmailVerificationService;
use App\Services\V1\Verification\PhoneVerificationService;


class MerchantSignupService extends BaseService
{

  use UserTypeCheckerTrait, BusinessProfileTrait;

  public function __construct(private PhoneVerificationService $phoneVerificationService, private EmailVerificationService $emailVerificationService)
  {
    $this->phoneVerificationService = $phoneVerificationService;
    $this->emailVerificationService = $emailVerificationService;
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
      $phone = UtilityHelper::formatPhoneNumber($request->phone);
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

      $this->phoneVerificationService->send($user);
      $this->emailVerificationService->send($user);

      DB::commit();
      return Responser::send(JsonResponse::HTTP_CREATED, [
        'token' => auth()->login($user),
        'user' => $user
      ], 'Signup successful. Verification detials has been sent.');
    } catch (Exception $e) {
      DB::rollback();
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

}
