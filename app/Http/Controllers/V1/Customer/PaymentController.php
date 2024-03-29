<?php

namespace App\Http\Controllers\V1\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\InitializePaymentRequest;
use Illuminate\Http\JsonResponse;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use App\Models\Payment;
use Exception;


class PaymentController extends Controller
{

  /**
   * @param PaymentService $Payment
   */
  public function __construct(public PaymentService $payment)
  {
    $this->payment = $payment;
  }

  /**
   * Add to Payment
   *
   * @param InitializePaymentRequest $request
   */
  public function initialize(InitializePaymentRequest $request): JsonResponse
  {
    return $this->payment->initialize($request->validated());
  }

  /**
   * Verify Payment
   *
   * @return JsonResponse
   */
  public function verify(Request $request)
  {
    return $this->payment->verify($request->get('reference'));
  }

}
