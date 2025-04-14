<?php

declare(strict_types=1);

namespace App\Services\V1\Kyc;
use App\Enums\Kyc\KycVerificationStatusEnum;
use App\Models\Kyc\KycVerification;
use App\Services\BaseService;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KycVerificationService extends BaseService
{
    /**
     * Initialize kyc verification
     */
    public function initialize(Request $request): JsonResponse
    {
        try {
            $user_id = auth()->id();
            $kycVerification = KycVerification::updateOrCreate(
                ['user_id' => $user_id, 'status' => KycVerificationStatusEnum::PENDING->value],
                [...$request->all(), 'status' => KycVerificationStatusEnum::PENDING->value, 'user_id' => $user_id]
            );

            return responser()->send(Status::HTTP_OK, $kycVerification, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
        }
    }

    public function info(): JsonResponse
    {
        try {
            $kyc_verification = KycVerification::with(['kycFiles'])->where(['user_id' => auth()->id()])->first();

            return responser()->send(Status::HTTP_OK, $kyc_verification, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
        }
    }
}
