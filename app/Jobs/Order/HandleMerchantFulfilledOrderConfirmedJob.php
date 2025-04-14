<?php

declare(strict_types=1);

namespace App\Jobs\Order;
use App\Enums\QueuedJobEnum;
use App\Models\Order\OrderFulfillment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandleMerchantFulfilledOrderConfirmedJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct()
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
        $order_fulfillments = OrderFulfillment::where(['payment_processed' => 0, 'is_confirmed' => 1, 'payment_authorized' => 1])->get();
        if ($order_fulfillments->count()) {
            $order_fulfillments->map(function ($order_fulfillment)
            {
                HandleConfirmedOrderPaymentJob::dispatch($order_fulfillment);
            });
        }
    }
}
