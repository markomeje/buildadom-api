<?php

namespace App\Http\Controllers\V1\Customer\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Customer\Auth\CustomerSignupRequest;
use App\Services\V1\Customer\Auth\CustomerSignupService;
use Illuminate\Http\JsonResponse;

class CustomerSignupController extends Controller
{
  /**
   * @param CustomerSignupService $customerSignupService
   */
  public function __construct(private CustomerSignupService $customerSignupService)
  {
    $this->customerSignupService = $customerSignupService;
  }

  /**
   * @param CustomerSignupRequest $request
   * @return JsonResponse
   */
  public function signup(CustomerSignupRequest $request): JsonResponse
  {
    return $this->customerSignupService->signup($request);
  }
}