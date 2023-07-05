<?php


namespace App\Services;
use App\Enums\PaymentStatusEnum;
use Illuminate\Http\JsonResponse;
use App\Models\Payment;
use App\Integrations\Paystack;
use Exception;


class PaymentService
{

  /**
   * @param PaymentService $Payment
   */
  public function __construct(public Payment $payment, public Paystack $paystack)
  {
    $this->payment = $payment;
    $this->paystack = $paystack;
  }

  /**
   * initialize Payment Record
   *
   * @return JsonResponse
   * @param array $data
   *
   */
  public function initialize(array $data): JsonResponse
  {
    try {
      $user_id = auth()->id();
      $order_id = $data['order_id'];
      $payment = $this->payment->where(['order_id' => $order_id, 'user_id' => $user_id])->first();

      $reference = str()->uuid();
      if (empty($payment)) {
        $payment = $this->payment->create([
          ...$data,
          'status' => PaymentStatusEnum::INITIALIZED->value,
          'user_id' => $user_id,
          'reference' => $reference,
          'type' => 'paystack',
        ]);
      }else {
        $payment->amount = $data['amount'];
        $payment->update();
      }

      $details = ["amount" => (float)($data['amount'] * 100), "reference" => $reference, "currency" => "NGN", "orderID" => $data['order_id'], "email" => auth()->user()->email];

      $paystack = $this->paystack->initialize($details);
      return response()->json([
        'success' => true,
        'payment' => $this->payment->find($payment->id),
        'payment_auth_url' => $paystack->data->authorization_url,
        'message' => 'Operation successful'
      ]);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage()
      ], 500);
    }
  }

  /**
   * Get all payments
   *
   * @return JsonResponse
   *
   */
  public function payments(): JsonResponse
  {
    try {
      return response()->json([
        'success' => true,
        'payments' => $this->payment->latest()->get(),
        'message' => 'Operation successful'
      ]);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage()
      ], 500);
    }
  }

  /**
   * Verify payment
   *
   * @return JsonResponse
   *
   */
  public function verify($reference = ''): JsonResponse
  {
    try {
      $payment = $this->getPaymentDetails($reference);
      if (empty($payment)) {
        return response()->json([
          'success' => false,
          'message' => 'Invalid payment'
        ]);
      }

      $paystack = $this->paystack->verify($reference);
      if (strtolower($paystack->data->status ?? '') === 'success') {
        $payment->status = PaymentStatusEnum::PAID->value;
        $payment->authorization_code = $paystack->data->authorization->authorization_code;
        $payment->update();

        return response()->json([
          'success' => true,
          'payment' => $this->getPaymentDetails($reference),
          'message' => 'Operation successful'
        ]);
      }

      return response()->json([
        'success' => false,
        'message' => 'Operation failed'
      ]);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage()
      ], 500);
    }
  }

  /**
   * Get payment
   *
   * @return JsonResponse
   *
   */
  public function getPaymentDetails($reference = '')
  {
    return $this->payment->where(['reference' => $reference])->first();
  }


}












