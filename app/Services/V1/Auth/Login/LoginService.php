<?php

namespace App\Services\V1\Auth\Login;
use App\Models\User;
use App\Services\BaseService;
use App\Utility\Responser;
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
      $user = User::query()->where(['email' => $request->email])->first();
      if (empty($user)) {
        return Responser::send(JsonResponse::HTTP_UNAUTHORIZED, [], 'Invalid account details. Try again.');
      }

      if(!Hash::check($request->password, $user->password)) {
        return Responser::send(JsonResponse::HTTP_UNAUTHORIZED, [], 'Invalid account details.');
      }

      $token = auth()->attempt($request->validated());
      if (!$token) {
        return Responser::send(JsonResponse::HTTP_UNAUTHORIZED, [], 'Invalid account details.');
      }

      return Responser::send(JsonResponse::HTTP_OK, ['user' => auth()->user(), 'token' => $token], 'Login successful');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], 'Ooops! login failed. Try again.');
    }
  }
}