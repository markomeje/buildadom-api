<?php

namespace App\Jobs\V1;
use App\Enums\Payment\PaymentStatusEnum;
use App\Integrations\Paystack;
use App\Models\Payment\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

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
    $this->onQueue(config('constants.queue.payment'));
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $payments = Payment::where('status', PaymentStatusEnum::INITIALIZED->value)
      ->orWhere('status', PaymentStatusEnum::ONGOING->value)
      ->orWhere('status', PaymentStatusEnum::PENDING->value)
      ->orWhere('status', PaymentStatusEnum::PROCESSING->value)
      ->orWhere('status', PaymentStatusEnum::QUEUED->value)
      ->get();

    if (empty($payments->count())) {
      return;
    }

    foreach ($payments as $payment) {
      $response = Paystack::payment()->verify($payment->reference);
      if(isset($response['status']) && (boolean)$response['status'] == true) {
        $data = $response['data'] ?? null;

        $status = strtolower($data['status'] ?? PaymentStatusEnum::INITIALIZED->value);
        $payment->update(['status' => $status, 'response' => $data]);
      }
    }

  }

}
