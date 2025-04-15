<?php

namespace App\Traits\Payment;
use App\Enums\Payment\TransferPaymentStatusEnum;
use App\Models\Payment\Payment;
use App\Models\User;
use App\Traits\CurrencyTrait;
use Illuminate\Database\Eloquent\Builder;

trait PaymentTrait
{
    use CurrencyTrait;

    /**
     * @param  \App\Models\User  $user|Illuminate\Database\Eloquent\Builder
     * @return Payment|\Illuminate\Database\Eloquent\Model
     */
    public function initializePayment(User|Builder $user, string $reference, float|int $amount, float|int $fee, string $type, ?string $account_type = null)
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
