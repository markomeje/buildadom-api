<?php

declare(strict_types=1);

namespace App\Jobs\Payment;
use App\Enums\QueuedJobEnum;
use App\Models\Bank\BankAccount;
use App\Partners\Paystack;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreatePaystackTransferRecipientJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

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
        $accounts = BankAccount::where(['transfer_recipient_created' => 0, 'recipient_code' => null])->get();
        if ($accounts->count()) {
            $accounts->map(function ($account)
            {
                $this->createRecipient($account);
            });
        }
    }

    /**
     * @param  BankAccount  $account
     * @return void
     */
    private function createRecipient($account)
    {
        $result = Paystack::payment()->createRecipient($account);
        if (($result['status'] ?? 0)) {
            $account->update([
                'recipient_code' => $result['data']['recipient_code'],
                'transfer_recipient_created' => 1,
            ]);
        }
    }
}
