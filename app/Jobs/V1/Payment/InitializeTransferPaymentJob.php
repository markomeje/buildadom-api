<?php

namespace App\Jobs\V1\Payment;
use App\Enums\QueuedJobEnum;
use App\Jobs\V1\Payment\MakePaystackTransferPaymentJob;
use App\Models\Bank\BankAccount;
use App\Models\Payment\Payment;
use App\Traits\V1\Payment\PaymentTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InitializeTransferPaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, PaymentTrait;

    /**
     * @param \App\Models\Payment\Payment $payment
     * @param \App\Models\Bank\BankAccount $bank
     */
    public function __construct(private Payment $payment, private BankAccount $bank)
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
        MakePaystackTransferPaymentJob::dispatch($this->payment, $this->bank);
    }

}
