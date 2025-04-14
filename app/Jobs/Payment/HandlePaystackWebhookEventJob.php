<?php

declare(strict_types=1);

namespace App\Jobs\Payment;
use App\Enums\QueuedJobEnum;
use App\Jobs\LogDeveloperInfoJob;
use App\Models\Payment\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandlePaystackWebhookEventJob implements ShouldQueue
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
    public function __construct(private mixed $payload)
    {
        $this->payload = (array) $payload;
        $this->onQueue(QueuedJobEnum::PAYMENT->value);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $paystack = $this->payload['data'];
        $payment = Payment::where('reference', $paystack['reference'])->first();
        if (empty($payment)) {
            LogDeveloperInfoJob::dispatch('Paystack webhook payload reference is invalid');

            return;
        }

        $data = ['status' => $paystack['status'], 'webhook_response' => $this->payload];
        if (in_array($this->payload['event'], $this->events()['transfer'])) {
            $data = array_merge($data, ['transfer_code' => $paystack['transfer_code']]);
        }

        $payment->update($data);
    }

    /**
     * @return array
     */
    private function events()
    {
        return [
            'transfer' => [
                'transfer.failed',
                'transfer.success',
                'transfer.reversed',
            ],
            'charge' => [
                'charge.success',
            ],
        ];
    }
}
