<?php

namespace App\Http\Controllers\V1\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\ConfirmPasswordResetCodeRequest;
use App\Http\Requests\V1\Auth\InitiatePasswordResetRequest;
use App\Http\Requests\V1\Auth\ResetPasswordRequest;
use App\Services\V1\Auth\PasswordResetService;
use Illuminate\Http\JsonResponse;

class PasswordResetController extends Controller
{
    public function __construct(
        private PasswordResetService $passwordResetService
    ) {}

    public function initiate(InitiatePasswordResetRequest $request): JsonResponse
    {
        return $this->passwordResetService->initiate($request);
    }

    /**
     * @param  ResetPasswordRequest  $requests
     */
    public function reset(ResetPasswordRequest $request): JsonResponse
    {
        return $this->passwordResetService->reset($request);
    }

    /**
     * @param  ConfirmPasswordResetCodeRequest  $requests
     */
    public function confirm(ConfirmPasswordResetCodeRequest $request): JsonResponse
    {
        return $this->passwordResetService->confirm($request);
    }
}
