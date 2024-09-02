<?php

namespace App\Jobs\V1\Escrow;
use App\Enums\Escrow\EscrowBalanceTypeEnum;
use App\Enums\Queue\QueueEnum;
use App\Models\User;
use App\Notifications\V1\Escrow\EscrowAccountCreditedNotification;
use App\Traits\V1\Escrow\EscrowAccountTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreditEscrowAccountJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, EscrowAccountTrait;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct(private User $user, private float $amount)
  {
    $this->onQueue(QueueEnum::ESCROW->value);
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $this->user->notify(new EscrowAccountCreditedNotification($this->amount));
    $escrow = $this->creditEscrowAccount($this->user, $this->amount);
    LogEscrowAccountBalanceJob::dispatch($escrow['new_balance'], $escrow['old_balance'], $escrow['escrow_account_id'], $this->amount, EscrowBalanceTypeEnum::CREDIT->value, $this->user->id);
  }

}
