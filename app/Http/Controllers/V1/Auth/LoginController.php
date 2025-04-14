<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Services\V1\Auth\Login\LoginService;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct(private LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->loginService->signin($request);
    }

    public function logout(): JsonResponse
    {
        return $this->loginService->logout();
    }
}
