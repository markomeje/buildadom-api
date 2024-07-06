<?php

namespace App\Jobs\V1\Payment;
use App\Enums\Queue\QueueEnum;
use App\Integrations\Paystack;
use App\Models\Bank\BankAccount;
use App\Models\Payment\TransferPayment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InitiatePaystackTransferPaymentJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct(private TransferPayment $transfer, private BankAccount $account, private int $amount)
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
    $fields = [
      'reference' => $this->transfer->reference,
      'recipient' => $this->account->recipient_code,
      'amount' => $this->amount * 100,
    ];

    $result = Paystack::payment()->initiateTransfer($fields);
    $this->handleResult((array)$result);
  }

  /**
   * @param array $result
   * @return mixed
   */
  private function handleResult($result)
  {
    $message = $result['message'];
    if(!($result['status'] ?? 0)) {
      $this->transfer->update(['message' => $message, 'is_failed' => 1]);
      return null;
    }

    $data = $result['data'];
    return $this->transfer->update([
      'status' => $data['status'],
      'message' => $message,
      'transfer_code' => $data['transfer_code'],
      'response' => $data,
      'is_failed' => 0
    ]);
  }

}
