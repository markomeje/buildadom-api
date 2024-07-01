<?php

namespace App\Jobs\V1;
use App\Enums\Payment\PaymentStatusEnum;
use App\Enums\Queue\QueueEnum;
use App\Integrations\Paystack;
use App\Models\Payment\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VerifyPaymentJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct()
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
    $payments = Payment::whereIn('status', [
      PaymentStatusEnum::INITIALIZED->value,
      PaymentStatusEnum::ONGOING->value,
      PaymentStatusEnum::PROCESSING->value,
      PaymentStatusEnum::PENDING->value,
      PaymentStatusEnum::QUEUED->value,
      PaymentStatusEnum::ABANDONED->value,
    ])->get();

    if ($payments->count() > 0) {
      foreach ($payments as $payment) {
        $this->handlePaymentStatus($payment);
      }
    }
  }

  /**
   * @param Payment $payment
   */
  private function handlePaymentStatus(Payment $payment)
  {
    $response = Paystack::payment()->verify($payment->reference);
    if(isset($response['status']) && (boolean)$response['status'] == true) {
      $data = $response['data'] ?? null;

      $status = strtolower($data['status'] ?? PaymentStatusEnum::INITIALIZED->value);
      $payment->update(['status' => $status, 'response' => $data]);
    }
  }

}
