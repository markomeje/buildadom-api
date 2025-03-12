<?php

namespace App\Jobs\V1\Order;
use App\Enums\QueuedJobEnum;
use App\Models\Order\OrderFulfillment;
use App\Notifications\V1\Order\MerchantFulfilledOrderConfirmedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandleMerchantFulfilledOrderConfirmedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param OrderFulfillment $order_fulfillment
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
        $order->store->merchant->notify(new MerchantFulfilledOrderConfirmedNotification($order));
        ProcessConfirmedOrderPaymentDisbursementsJob::dispatch($this->order_fulfillment);
    }

}
