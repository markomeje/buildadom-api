<?php

namespace App\Traits\V1\Payment;
use App\Enums\Payment\TransferPaymentStatusEnum;
use App\Models\Payment\TransferPayment;
use App\Models\User;
use App\Traits\V1\CurrencyTrait;
use Exception;

trait TransferPaymentTrait
{
  use CurrencyTrait;

  /**
   * @param User $user
   * @param string $reference,
   * @param float $amount
   * @return TransferPayment
   */
  public function initializeTransferPayment(User $user, string $reference, $amount)
  {
    $user_id = $user->id;
    return TransferPayment::updateOrCreate([
      'reference' => $reference,
      'status' => TransferPaymentStatusEnum::INITIALIZED->value,
      'user_id' => $user_id,
    ], [
      'amount' => $amount,
      'status' => TransferPaymentStatusEnum::INITIALIZED->value,
      'currency_id' => $this->getDefaultCurrency()->id,
      'reference' => $reference,
      'user_id' => $user_id,
    ]);
  }

}