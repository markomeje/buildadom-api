<?php

namespace App\Jobs\Payment;
use App\Enums\QueuedJobEnum;
use App\Models\Bank\BankAccount;
use App\Models\Payment\Payment;
use App\Notifications\V1\Payment\TransferPaymentProcessedNotification;
use App\Partners\Paystack;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MakePaystackTransferPaymentJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private Payment $payment, private BankAccount $account)
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
        $payload = [
            'reference' => $this->payment->reference,
            'recipient' => $this->account->recipient_code,
            'amount' => $this->payment->total_amount * 100,
        ];

        $result = Paystack::payment()->initiateTransfer($payload);
        $this->handleTransferResult($result);
    }

    /**
     * @param  array  $transfer_result
     * @return mixed
     */
    private function handleTransferResult($transfer_result)
    {
        $result = (array) $transfer_result;
        $message = $result['message'] ?? '';

        if (empty($result['status']) || empty($result['data'])) {
            $this->payment->update(['message' => $message, 'is_failed' => 1]);

            return null;
        }

        $data = $result['data'];
        $this->payment->user->notify(new TransferPaymentProcessedNotification);

        return $this->payment->update([
            'status' => $data['status'],
            'message' => $message,
            'transfer_code' => $data['transfer_code'],
            'initialize_response' => $data,
            'is_failed' => 0,
        ]);
    }
}
