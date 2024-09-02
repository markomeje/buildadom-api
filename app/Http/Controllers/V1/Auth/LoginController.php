<?php

namespace App\Http\Controllers\V1\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Services\V1\Auth\Login\LoginService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{

  /**
   * @param LoginService $loginService
   */
  public function __construct(private LoginService $loginService)
  {
    $this->loginService = $loginService;
  }

  /**
   * @param LoginRequest $request
   * @return JsonResponse
   */
  public function login(LoginRequest $request): JsonResponse
  {
    return $this->loginService->signin($request);
  }

  /**
   * @return JsonResponse
   */
  public function logout(): JsonResponse
  {
    return $this->loginService->logout();
  }
}
