<?php

namespace App\Jobs\V1\Payment;
use App\Enums\Payment\PaymentStatusEnum;
use App\Enums\Queue\QueueEnum;
use App\Integrations\Paystack;
use App\Jobs\V1\Escrow\CreditEscrowAccountJob;
use App\Models\Payment\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PaystackPaymentVerificationJob implements ShouldQueue
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

    if ($payments->count()) {
      $payments->map(function($payment) {
        $this->handlePaymentStatus($payment);
      });
    }
  }

  /**
   * @param Payment $payment
   */
  private function handlePaymentStatus(Payment $payment)
  {
    $result = Paystack::payment()->verify($payment->reference);
    Log::info('Paystack Payment Verification Result - '.json_encode($result));

    if(empty($result['status']) || empty($result['data'])) {
      $payment->update(['message' => $result['message'] ?? '', 'is_failed' => 1]);
      return null;
    }

    $data = $result['data'];
    $status = strtolower($data['status']);

    $payment->update(['status' => $status, 'response' => $data]);
    if($status === strtolower(PaymentStatusEnum::SUCCESS->value)) {
      CreditEscrowAccountJob::dispatch($payment->user, (float)$payment->amount);
    }
  }

}
