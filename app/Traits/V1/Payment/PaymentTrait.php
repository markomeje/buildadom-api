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
     * @param \App\Models\User $user|Illuminate\Database\Eloquent\Builder
     * @param string $reference
     * @param float|int $amount
     * @param float|int $fee
     * @param string $type
     * @param string|null $account_type
     * @return Payment|\Illuminate\Database\Eloquent\Model
     */
    public function initializePayment(User $user, string $reference, float|int $amount, float|int $fee = 0, string $type, ?string $account_type = null)
    {
        $user_id = $user->id;
        return Payment::updateOrCreate([
            'status' => TransferPaymentStatusEnum::INITIALIZED->value,
            'user_id' => $user_id,
        ], [
            'fee' => $fee,
            'amount' => $amount,
            'total_amount' => $amount + $fee,
            'status' => TransferPaymentStatusEnum::INITIALIZED->value,
            'currency_id' => $this->getDefaultCurrency()->id,
            'account_type' => $account_type,
            'reference' => $reference,
            'user_id' => $user_id,
            'type' => $type,
        ]);
    }

}
