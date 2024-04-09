<?php

namespace App\Http\Controllers\V1\Customer\Payment;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Customer\Payment\InitializePaymentRequest;
use App\Services\V1\Customer\Payment\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
  /**
   * @param PaymentService $paymentService
   */
  public function __construct(private PaymentService $paymentService)
  {
    $this->paymentService = $paymentService;
  }

  /**
   * @param JsonResponse
   */
  public function verify()
  {}

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function initialize(Request $request): JsonResponse
  {
    return $this->paymentService->initialize($request);
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function list(Request $request): JsonResponse
  {
    return $this->paymentService->list($request);
  }

}