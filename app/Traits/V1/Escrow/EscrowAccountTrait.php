<?php

namespace App\Traits\V1\Escrow;
use App\Enums\Escrow\EscrowAccountStatusEnum;
use App\Enums\Escrow\EscrowBalanceTypeEnum;
use App\Jobs\V1\Escrow\LogEscrowAccountBalanceJob;
use App\Models\Escrow\EscrowAccount;
use App\Models\User;
use App\Notifications\V1\Escrow\EscrowAccountCreditedNotification;
use App\Notifications\V1\Escrow\EscrowAccountDebitedNotification;
use App\Traits\V1\CurrencyTrait;

trait EscrowAccountTrait
{
    use CurrencyTrait;

    /**
     * @param float $amount
     * @param User $user
     * @return EscrowAccount
     */
    public function creditEscrowAccount(User $user, float $amount)
    {
        $user_id = $user->id;
        $escrow = EscrowAccount::where(['user_id' => $user_id])->first();

        if(empty($escrow)) {
        $old_balance = $new_balance = (float)$amount;
            $escrow = EscrowAccount::create([
                'balance' => $new_balance,
                'user_id' => $user_id,
                'status' => EscrowAccountStatusEnum::ACTIVE->value,
                'currency_id' => $this->getDefaultCurrency()->id
            ]);
        }else {
            $old_balance = $escrow->balance ?? 0;
            $new_balance = (float)($old_balance + $amount);
            $escrow->update(['balance' => $new_balance]);
        }

        $user->notify(new EscrowAccountCreditedNotification($amount, $new_balance));
        LogEscrowAccountBalanceJob::dispatch($new_balance, $old_balance, $escrow, $amount, EscrowBalanceTypeEnum::CREDIT->value, $user);
        return $escrow;
    }

    /**
     * @param float $amount
     * @param User $user
     * @return EscrowAccount
     */
    public function debitEscrowAccount(User $user, float $amount)
    {
        $user_id = $user->id;
        $escrow = EscrowAccount::where(['user_id' => $user_id])->first();

        $old_balance = $escrow->balance ?? 0;
        $new_balance = (float)($old_balance - $amount);
        $escrow->update(['balance' => $new_balance]);

        $user->notify(new EscrowAccountDebitedNotification($amount, $new_balance));
        LogEscrowAccountBalanceJob::dispatch($new_balance, $old_balance, $escrow, $amount, EscrowBalanceTypeEnum::DEBIT->value, $user);
        return $escrow;
    }

}
