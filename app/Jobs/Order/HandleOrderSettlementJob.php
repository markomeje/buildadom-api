<?php

namespace App\Jobs\Order;
use App\Enums\Order\OrderSettlementStatusEnum;
use App\Enums\Payment\PaymentAccountTypeEnum;
use App\Enums\QueuedJobEnum;
use App\Jobs\Escrow\DebitEscrowAccountJob;
use App\Jobs\Payment\InitializeTransferPaymentJob;
use App\Models\Order\Order;
use App\Models\Order\OrderSettlement;
use App\Models\Payment\Payment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandleOrderSettlementJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private Order $order, private User $user, private Payment $payment)
    {
        $this->onQueue(QueuedJobEnum::ORDER->value);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (strtoupper($this->payment->account_type) == strtoupper(PaymentAccountTypeEnum::ESCROW->value)) {
            DebitEscrowAccountJob::dispatch($this->order->customer, (float) $this->order->total_amount);
        }

        InitializeTransferPaymentJob::dispatch($this->payment, $this->user->bank);
        OrderSettlement::updateOrCreate([
            'merchant_id' => $this->user->id,
            'order_id' => $this->order->id,
            'status' => OrderSettlementStatusEnum::PROCESSED->value,
        ], [
            'merchant_id' => $this->user->id,
            'order_id' => $this->order->id,
            'payment_id' => $this->payment->id,
            'description' => 'Process merchant payment for order fulfilled',
            'status' => OrderSettlementStatusEnum::PROCESSED->value,
        ]);
    }
}
