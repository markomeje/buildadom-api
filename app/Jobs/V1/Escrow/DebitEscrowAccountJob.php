<?php

namespace App\Jobs\V1\Escrow;
use App\Enums\Queue\QueueEnum;
use App\Models\User;
use App\Traits\V1\Escrow\EscrowAccountTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DebitEscrowAccountJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, EscrowAccountTrait;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct(private User $user, private float $amount)
  {
    $this->user = $user;
    $this->amount = $amount;
    $this->onQueue(QueueEnum::ESCROW->value);
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $this->debitEscrowAccount($this->user, $this->amount);
  }

}
