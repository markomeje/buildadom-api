<?php

namespace App\Http\Middleware;
use App\Enums\Kyc\KycVerificationStatusEnum;
use App\Models\Kyc\KycVerification;
use App\Utility\Status;
use Closure;
use Illuminate\Http\Request;

class MerchantKycVerifiedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $kyc_verified = KycVerification::where(['user_id' => auth()->id(), 'status' => KycVerificationStatusEnum::VERIFIED->value])->first();
        if (empty($kyc_verified)) {
            return responser()->send(Status::HTTP_FORBIDDEN, null, 'Invalid KYC verification.');
        }

        return $next($request);
    }
}
