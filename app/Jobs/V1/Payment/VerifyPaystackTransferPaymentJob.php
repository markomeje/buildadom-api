<?php

namespace App\Jobs\V1\Payment;
use App\Enums\Queue\QueueEnum;
use App\Integrations\Paystack;
use App\Models\Payment\TransferPayment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

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
    $this->onQueue(QueueEnum::PAYMENT->value);
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $transfers = TransferPayment::where(['is_failed' => 1])->get();
    if($transfers->count()) {
      $transfers->map(function($transfer) {
        $this->handleVerifyTransferResult($transfer);
      });
    }
  }

  /**
   * @param array $result
   * @return mixed
   */
  private function handleVerifyTransferResult($transfer)
  {
    $result = Paystack::payment()->verifyTransfer($transfer->reference);
    Log::info(json_encode($result));

    $message = $result['message'];
    if(!($result['status'] ?? 0)) {
      $transfer->update(['message' => $message, 'is_failed' => 1]);
      return null;
    }

    $data = $result['data'];
    return $transfer->update([
      'status' => $data['status'],
      'message' => $message,
      'transfer_code' => $data['transfer_code'],
      'response' => $data,
      'is_failed' => 0
    ]);
  }

}
