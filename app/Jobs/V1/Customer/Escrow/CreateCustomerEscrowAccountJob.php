<?php

namespace App\Jobs\V1\Customer\Escrow;
use App\Enums\Escrow\EscrowAccountStatusEnum;
use App\Enums\Payment\PaymentStatusEnum;
use App\Enums\Queue\QueueEnum;
use App\Models\Escrow\EscrowAccount;
use App\Models\Payment\Payment;
use App\Notifications\V1\Customer\Escrow\CustomerEscrowAccountCreditedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateCustomerEscrowAccountJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
    $customer = $payment->user;
    $total_amount = (float)$payment->amount;
    $escrow = EscrowAccount::create([
      'total_amount' => $total_amount,
      'payment_id' => $payment->id,
      'customer_id' => $customer->id,
      'status' => EscrowAccountStatusEnum::PAID->value
    ]);

    if($escrow) {
      $customer->notify(new CustomerEscrowAccountCreditedNotification($total_amount));
    }
  }

}
