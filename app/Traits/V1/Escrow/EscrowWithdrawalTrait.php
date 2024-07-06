<?php

namespace App\Traits\V1\Escrow;
use App\Enums\Escrow\EscrowBalanceTypeEnum;
use App\Models\Escrow\EscrowAccount;
use App\Models\Escrow\EscrowBalance;
use Exception;

trait EscrowWithdrawalTrait
{
  /**
   * @param int $escrow_account_id
   * @param float $amount
   * @return mixed
   */
  public function updateWidthBalance(int $escrow_account_id, $amount)
  {
    $escrow = EscrowAccount::find($escrow_account_id);
    $escrow_balance = $escrow->total_amount ?? 0;
    if($escrow_balance < $amount) {
      throw new Exception('Insufficient funds');
    }

    $new_balance = $escrow_balance - $amount;
    $escrow->update(['total_amount' => $new_balance]);
    EscrowBalance::create([
      'old_balance' => $escrow_balance,
      'new_balance' => $new_balance,
      'type' => EscrowBalanceTypeEnum::DEBIT->value,
      'escrow_account_id' => $escrow_account_id,
    ]);
  }

}