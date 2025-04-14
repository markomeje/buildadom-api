<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Phone;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Phone\PhoneVerificationRequest;
use App\Services\V1\Phone\PhoneVerificationService;
use Illuminate\Http\JsonResponse;

class PhoneVerificationController extends Controller
{
    public function __construct(private PhoneVerificationService $phoneVerificationService)
    {
        $this->phoneVerificationService = $phoneVerificationService;
    }

    /**
     * Verify phone number
     *
     * @param JsonResponse
     */
    public function verify(PhoneVerificationRequest $request): JsonResponse
    {
        return $this->phoneVerificationService->verify($request);
    }

    /**
     * Resend phone number verification code
     *
     * @param JsonResponse
     */
    public function resend(): JsonResponse
    {
        return $this->phoneVerificationService->resend();
    }
}
