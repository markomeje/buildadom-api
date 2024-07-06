<?php

namespace App\Jobs\V1\Payment;
use App\Enums\Queue\QueueEnum;
use App\Jobs\V1\Payment\InitiatePaystackTransferPaymentJob;
use App\Models\User;
use App\Traits\V1\Escrow\EscrowAccountTrait;
use App\Traits\V1\Payment\TransferPaymentTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InitializeTransferPaymentJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, EscrowAccountTrait, TransferPaymentTrait;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct(private User $user, private string $reference, private float $amount)
  {
    $this->onQueue(QueueEnum::PAYMENT->value);
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $transfer = $this->initializeTransferPayment($this->user, $this->reference, $this->amount);
    InitiatePaystackTransferPaymentJob::dispatch($transfer, $this->user->bank, (int)$this->amount);
  }

}
