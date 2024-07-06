<?php

namespace App\Jobs\V1\Payment;
use App\Enums\Queue\QueueEnum;
use App\Integrations\Paystack;
use App\Models\Bank\BankAccount;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreatePaystackTransferRecipientJob implements ShouldQueue
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
    $accounts = BankAccount::where(['transfer_recipient_created' => 0, 'recipient_code' => null])->get();
    if ($accounts->count()) {
      foreach ($accounts as $account) {
        $this->handleRecipientCreation($account);
      }
    }
  }

  /**
   * @param BankAccount $account
   * @return void
   */
  private function handleRecipientCreation($account)
  {
    $result = Paystack::payment()->createRecipient($account);
    if(($result['status'] ?? 0)) {
      $account->update([
        'recipient_code' => $result['data']['recipient_code'],
        'transfer_recipient_created' => 1,
      ]);
    }
  }

}
