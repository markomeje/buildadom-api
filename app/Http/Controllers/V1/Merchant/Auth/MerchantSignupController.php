<?php

namespace App\Http\Controllers\V1\Merchant\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Merchant\Auth\MerchantSignupRequest;
use App\Services\V1\Merchant\Auth\MerchantSignupService;
use Illuminate\Http\JsonResponse;

class MerchantSignupController extends Controller
{
    public function __construct(private MerchantSignupService $merchantSignup)
    {
        $this->merchantSignup = $merchantSignup;
    }

    /**
     * Signup marchant
     *
     * @return JsonResponse
     */
    public function signup(MerchantSignupRequest $request)
    {
        return $this->merchantSignup->signup($request);
    }
}
