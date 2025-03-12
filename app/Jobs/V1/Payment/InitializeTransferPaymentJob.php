<?php

namespace App\Jobs\V1\Payment;
use App\Enums\Payment\PaymentTypeEnum;
use App\Enums\QueuedJobEnum;
use App\Jobs\V1\Payment\InitiatePaystackTransferPaymentJob;
use App\Models\User;
use App\Traits\V1\Escrow\EscrowAccountTrait;
use App\Traits\V1\Payment\PaymentTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InitializeTransferPaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, EscrowAccountTrait, PaymentTrait;

    /**
     * @param User $merchant
     * @param string $reference
     * @param float $amount
     */
    public function __construct(private User $merchant, private string $reference, private float $amount)
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
        $payment = $this->initializePayment($this->merchant, $this->reference, $this->amount, 0, PaymentTypeEnum::TRANSFER->value);
        InitiatePaystackTransferPaymentJob::dispatch($payment, $this->merchant->bank);
    }

}
