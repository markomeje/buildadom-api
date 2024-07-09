<?php

namespace App\Traits\V1\Escrow;
use App\Enums\Escrow\EscrowAccountStatusEnum;
use App\Enums\Escrow\EscrowBalanceTypeEnum;
use App\Jobs\V1\Escrow\LogEscrowAccountBalanceJob;
use App\Models\Escrow\EscrowAccount;
use App\Models\User;
use App\Notifications\V1\Escrow\EscrowAccountDebitedNotification;
use App\Traits\V1\CurrencyTrait;

trait EscrowAccountTrait
{
  use CurrencyTrait;

  /**
   * @param float $amount
   * @param User $user
   * @return array
   */
  public function creditEscrowAccount(User $user, float $amount)
  {
    $user_id = $user->id;
    $escrow = EscrowAccount::where(['user_id' => $user_id])->first();

    if(empty($escrow)) {
      $new_balance = $old_balance = $amount;
      $escrow = EscrowAccount::create([
        'balance' => $new_balance,
        'user_id' => $user_id,
        'status' => EscrowAccountStatusEnum::ACTIVE->value,
        'currency_id' => $this->getDefaultCurrency()->id
      ]);
    }else {
      $old_balance = $escrow->balance ?? 0;
      $new_balance = $old_balance + $amount;
      $escrow->update(['balance' => $new_balance]);
    }

    return [
      'new_balance' => $new_balance,
      'old_balance' => $old_balance,
      'escrow_account_id' => $escrow->id
    ];
  }

  /**
   * @param float $amount
   * @param User $user
   * @return void
   */
  public function debitEscrowAccount(User $user, float $amount)
  {
    $user_id = $user->id;
    $escrow = EscrowAccount::where(['user_id' => $user_id])->first();
    $old_balance = $escrow->balance ?? 0;
    $new_balance = $old_balance - $amount;

    $escrow->update(['balance' => $new_balance]);
    $user->notify(new EscrowAccountDebitedNotification($amount));

    $balance_type = strtolower(EscrowBalanceTypeEnum::DEBIT->value);
    LogEscrowAccountBalanceJob::dispatch($new_balance, $old_balance, $escrow->id, $amount, $balance_type, $user_id);
  }

}