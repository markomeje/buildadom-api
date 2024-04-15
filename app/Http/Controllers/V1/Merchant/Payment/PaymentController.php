<?php

namespace App\Http\Controllers\V1\Merchant\Payment;
use App\Http\Controllers\Controller;
use App\Services\V1\Merchant\Payment\PaymentService;
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
   * @param Request $request
   * @return JsonResponse
   */
  public function list(Request $request): JsonResponse
  {
    return $this->paymentService->list($request);
  }

}