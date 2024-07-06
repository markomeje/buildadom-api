<?php

namespace App\Traits\V1;
use App\Enums\Payment\PaymentStatusEnum;
use App\Models\Payment\Payment;
use Exception;

trait PaymentTrait
{
  /**
   * @param int $user_id
   * @param float $total_amount
   * @param string $reference
   * @param int $currency_id
   * @throws Exception
   * @return Payment
   */
  public function createPayment(int $user_id, float $total_amount, string $reference, int $currency_id)
  {
    $payment = Payment::updateOrCreate([
      'user_id' => $user_id,
      'amount' => $total_amount,
      'status' => PaymentStatusEnum::INITIALIZED->value
    ], [
      'user_id' => $user_id,
      'amount' => $total_amount,
      'reference' => $reference,
      'status' => PaymentStatusEnum::INITIALIZED->value,
      'currency_id' => $currency_id,
    ]);

    if(empty($payment)) {
      throw new Exception('Unknown error. Payment operation failed.');
    }

    return $payment;
  }

}