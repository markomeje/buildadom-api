<?php

namespace App\Jobs\Order;
use App\Enums\Payment\PaymentTypeEnum;
use App\Enums\QueuedJobEnum;
use App\Models\Order\OrderFulfillment;
use App\Traits\Payment\PaymentTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandleConfirmedOrderPaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, PaymentTrait;

    /**
     * @param \App\Models\Order\OrderFulfillment $order_fulfillment
     */
    public function __construct(private OrderFulfillment $order_fulfillment)
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
        $order = $this->order_fulfillment->order;
        $merchant = $order->store->merchant;

        $payment = $this->initializePayment($merchant, str()->uuid(), (float)$order->total_amount, 0, PaymentTypeEnum::TRANSFER->value);
        HandleOrderSettlementJob::dispatch($order, $merchant, $payment);
        $this->order_fulfillment->update(['payment_processed' => 1]);
    }

}
