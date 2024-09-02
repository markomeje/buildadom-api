<?php

namespace App\Traits\V1\Payment;
use App\Enums\Payment\TransferPaymentStatusEnum;
use App\Models\Payment\Payment;
use App\Models\User;
use App\Traits\V1\CurrencyTrait;

trait PaymentTrait
{
  use CurrencyTrait;

  /**
   * @param User $user
   * @param string $reference,
   * @param float|int $amount
   * @param string $type
   * @param float|int $fee
   * @param array $payload
   * @return Payment
   */
  public function initializePayment(User $user, string $reference, float|int $amount, string $type, float|int $fee = 0, array $payload = [])
  {
    $user_id = $user->id;
    return Payment::updateOrCreate([
      'reference' => $reference,
      'status' => TransferPaymentStatusEnum::INITIALIZED->value,
      'user_id' => $user_id,
    ], [
      'amount' => $amount,
      'total_amount' => $amount + $fee,
      'status' => TransferPaymentStatusEnum::INITIALIZED->value,
      'currency_id' => $this->getDefaultCurrency()->id,
      'reference' => $reference,
      'user_id' => $user_id,
      'type' => $type,
      'payload' => $payload
    ]);
  }

}