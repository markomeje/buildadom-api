<?php

namespace App\Jobs\V1\Payment;
use App\Enums\Payment\PaymentTypeEnum;
use App\Enums\QueuedJobEnum;
use App\Integrations\Paystack;
use App\Models\Payment\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VerifyPaystackTransferPaymentJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->onQueue(QueuedJobEnum::PAYMENT->value);
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $transfers = Payment::where(['is_failed' => 1, 'type' => PaymentTypeEnum::TRANSFER->value])->get();
    if($transfers->count()) {
      $transfers->map(function($payment) {
        $this->handleResult($payment);
      });
    }
  }

  /**
   * @param array $result
   * @return mixed
   */
  private function handleResult($payment)
  {
    $result = Paystack::payment()->verifyTransfer($payment->reference);
    $message = $result['message'] ?? '';
    if(empty($result['status']) || empty($result['data'])) {
      $payment->update(['message' => $message, 'is_failed' => 1]);
      return null;
    }

    $data = $result['data'];
    $payment->update([
      'status' => $data['status'],
      'message' => $message,
      'transfer_code' => $data['transfer_code'],
      'response' => $data,
      'is_failed' => 0,
      'verify_response' => $result
    ]);
  }

}
