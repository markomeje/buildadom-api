<?php

declare(strict_types=1);

namespace App\Jobs\Payment;
use App\Enums\QueuedJobEnum;
use App\Models\Bank\BankAccount;
use App\Models\Payment\Payment;
use App\Traits\Payment\PaymentTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InitializeTransferPaymentJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use PaymentTrait;
    use Queueable;
    use SerializesModels;

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
