<?php

namespace App\Jobs\Order;
use App\Enums\QueuedJobEnum;
use App\Models\Order\Order;
use App\Notifications\V1\Order\CustomerConfirmOrderFulfilledNotification;
use App\Traits\Order\OrderFulfillmentTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandleMerchantFulfilledOrderJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use OrderFulfillmentTrait;
    use Queueable;
    use SerializesModels;

    public function __construct(private Order $order)
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
        $confirmation_code = help()->generateRandomDigits(6);
        $this->saveOrderFulfillment($this->order, $confirmation_code);
        $this->order->customer->notify(new CustomerConfirmOrderFulfilledNotification($this->order->tracking_number, $confirmation_code));
    }
}
