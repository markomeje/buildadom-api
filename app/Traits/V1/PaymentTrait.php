<?php

namespace App\Traits\V1;
use App\Enums\Payment\PaymentStatusEnum;
use App\Models\Payment\Payment;
use Exception;

trait PaymentTrait
{
  /**
   * @param array $payloa
   * @param int $user_id
   * @param float $total_amount
   * @param float $amount
   * @param float $fee
   * @param int $currency_id
   * @throws Exception
   * @return Payment
   */
  public function createPayment(array $payload, int $user_id, float $total_amount, float $amount, float $fee, int $currency_id)
  {
    $payment = Payment::updateOrCreate([
      'user_id' => $user_id,
      'amount' => $amount,
      'status' => PaymentStatusEnum::INITIALIZED->value
    ], [
      'user_id' => $user_id,
      'total_amount' => $total_amount,
      'amount' => $amount,
      'fee' => $fee,
      'reference' => $payload['reference'],
      'status' => PaymentStatusEnum::INITIALIZED->value,
      'currency_id' => $currency_id,
      'payload' => $payload
    ]);

    if(empty($payment)) {
      throw new Exception('Unknown error. Payment operation failed.');
    }

    return $payment;
  }

}