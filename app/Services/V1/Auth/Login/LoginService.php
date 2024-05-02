<?php

namespace App\Services\V1\Auth\Login;
use App\Enums\User\UserRoleEnum;
use App\Models\User;
use App\Services\BaseService;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginService extends BaseService
{
  /**
   * Login process
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function signin(Request $request): JsonResponse
  {
    try {
      $user = User::where(['email' => $request->email])->first();
      if (empty($user)) {
        return Responser::send(Status::HTTP_BAD_REQUEST, [], 'Invalid account details. Try again.');
      }

      if(!Hash::check($request->password, $user->password)) {
        return Responser::send(Status::HTTP_BAD_REQUEST, [], 'Invalid account details.');
      }

      $token = auth()->attempt($request->validated());
      if (!$token) {
        return Responser::send(Status::HTTP_BAD_REQUEST, [], 'Invalid account details.');
      }

      $roles = array_map('strtolower', $user->roles()->pluck('name')->toArray());
      if(in_array(strtolower(UserRoleEnum::MERCHANT->value), $roles)) {
        return Responser::send(Status::HTTP_OK, [
          'user' => auth()->user(),
          'token' => $token,
          'stores' => $user->stores,
          'email_verification' => $user->emailVerification,
          'phone_verification' => $user->phoneVerification,
        ], 'Login successful');
      }

      return Responser::send(Status::HTTP_OK, ['user' => auth()->user(), 'token' => $token], 'Login successful');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Ooops! login failed. Try again.');
    }
  }
}