<?php

namespace App\Jobs\V1;
use App\Enums\Escrow\EscrowAccountStatusEnum;
use App\Enums\Payment\PaymentStatusEnum;
use App\Enums\Queue\QueueEnum;
use App\Models\Escrow\EscrowAccount;
use App\Models\Payment\Payment;
use App\Notifications\Merchant\EscrowAccountCreditedNotification;
use App\Traits\MerchantTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class HandleEscrowAccountJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, MerchantTrait;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct()
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
    $payments = Payment::where('status', PaymentStatusEnum::SUCCESS->value)->get();
    if ($payments->count() > 0) {
      foreach ($payments as $payment) {
        if(!$payment->escrow) {
          $this->createEscrowAccount($payment);
        }
      }
    }
  }

  /**
   * @param Payment $payment
   */
  private function createEscrowAccount(Payment $payment)
  {
    $user_id = $payment->user_id;
    $total_amount = (float)$payment->amount;
    $escrow = EscrowAccount::create([
      'total_amount' => $total_amount,
      'payment_id' => $payment->id,
      'user_id' => $user_id,
      'status' => EscrowAccountStatusEnum::PAID->value
    ]);

    if($escrow) {
      $merchant = $this->getMerchantUser($user_id);
      $merchant->notify(new EscrowAccountCreditedNotification($total_amount));
    }
  }

}
