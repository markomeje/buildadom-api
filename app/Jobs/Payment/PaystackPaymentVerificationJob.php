<?php

namespace App\Jobs\Payment;
use App\Enums\Payment\PaymentStatusEnum;
use App\Enums\Queue\QueueEnum;
use App\Models\Payment\Payment;
use App\Partners\Paystack;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * For local dev only
 */
class PaystackPaymentVerificationJob implements ShouldQueue
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
            $payments->map(function ($payment) {
                $this->handlePaymentStatus($payment);
            });
        }
    }

    private function handlePaymentStatus(Payment $payment)
    {
        $result = Paystack::payment()->verify($payment->reference);
        if (empty($result['status']) || empty($result['data'])) {
            $payment->update(['message' => $result['message'] ?? '', 'is_failed' => 1]);

            return null;
        }

        $data = $result['data'];
        $payment->update(['response' => $data, 'status' => strtolower($data['status'])]);
    }
}
