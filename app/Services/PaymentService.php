<?php


namespace App\Services;
use App\Enums\PaymentStatusEnum;
use Illuminate\Http\JsonResponse;
use App\Models\Payment;
use Exception;


class PaymentService
{

  /**
   * @param PaymentService $Payment
   */
  public function __construct(public Payment $payment)
  {
    $this->payment = $payment;
  }

  /**
   * create Payment Record
   *
   * @return JsonResponse
   * @param array $data
   *
   */
  public function create(array $data): JsonResponse
  {
    try {
      $payment = $this->payment->create([
        ...$data,
        'paid' => PaymentStatusEnum::NOT_PAID->value,
        'user_id' => auth()->id(),
        'reference' => str()->uuid(),
      ]);

      return response()->json([
        'success' => true,
        'payment' => $payment,
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

}












