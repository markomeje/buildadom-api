<?php

namespace App\Traits\V1;
use App\Enums\Payment\PaymentStatusEnum;
use App\Models\Payment\Payment;

trait PaymentTrait
{
  /**
   * @param int $user_id
   * @param float $total_amount
   * @param string $reference
   * @param int $currency_id
   * @param array|null $payload
   * @return null|Payment
   */
  public function createPayment($user_id, $total_amount, $reference, $currency_id, $payload = null)
  {
    return Payment::updateOrCreate([
      'user_id' => $user_id,
      'amount' => $total_amount,
      'status' => PaymentStatusEnum::INITIALIZED->value
    ], [
      'user_id' => $user_id,
      'amount' => $total_amount,
      'reference' => $reference,
      'status' => PaymentStatusEnum::INITIALIZED->value,
      'payload' => $payload,
      'currency_id' => $currency_id,
    ]);
  }

}