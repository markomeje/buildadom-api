<?php

namespace App\Http\Controllers\V1\Merchant\Auth;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\V1\Merchant\Auth\MerchantSignupService;
use App\Http\Requests\V1\Merchant\Auth\MerchantSignupRequest;


class MerchantSignupController extends Controller
{

  public function __construct(private MerchantSignupService $merchantSignupService)
  {
    $this->merchantSignupService = $merchantSignupService;
  }

  /**
   * Signup marchant
   * @param MerchantSignupRequest $request
   * @return JsonResponse
   */
  public function signup(MerchantSignupRequest $request)
  {
    return $this->merchantSignupService->signup($request);
  }

}
