<?php

namespace App\Services\V1\Customer\Auth;
use App\Models\User;
use App\Services\BaseService;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerLoginService extends BaseService
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
      $user = User::query()->where(['email' => $request->email])->first();
      if (empty($user)) {
        return Responser::send(Status::HTTP_UNAUTHORIZED, [], 'Invalid account details. Try again.');
      }

      if(!Hash::check($request->password, $user->password)) {
        return Responser::send(Status::HTTP_UNAUTHORIZED, [], 'Invalid account details.');
      }

      $token = auth()->attempt($request->validated());
      if (!$token) {
        return Responser::send(Status::HTTP_UNAUTHORIZED, [], 'Invalid account details.');
      }

      return Responser::send(Status::HTTP_OK, ['user' => auth()->user(), 'token' => $token], 'Login successful');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Ooops! login failed. Try again.');
    }
  }
}