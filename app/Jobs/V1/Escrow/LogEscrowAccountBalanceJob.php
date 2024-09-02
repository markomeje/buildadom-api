<?php

namespace App\Jobs\V1\Escrow;
use App\Enums\Queue\QueueEnum;
use App\Models\Escrow\EscrowBalance;
use App\Traits\V1\Escrow\EscrowAccountTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LogEscrowAccountBalanceJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, EscrowAccountTrait;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct(private float $new_balance, private float $old_balance, private int $escrow_account_id, private float $amount, private string $balance_type, private int $user_id)
  {
    $this->new_balance = $new_balance;
    $this->old_balance = $old_balance;
    $this->escrow_account_id = $escrow_account_id;
    $this->amount = $amount;
    $this->balance_type = $balance_type;
    $this->user_id = $user_id;
    $this->onQueue(QueueEnum::ESCROW->value);
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    EscrowBalance::create([
      'old_balance' => $this->old_balance,
      'new_balance' => $this->new_balance,
      'balance_type' => $this->balance_type,
      'escrow_account_id' => $this->escrow_account_id,
      'amount' => $this->amount,
      'user_id' => $this->user_id,
    ]);
  }

}
