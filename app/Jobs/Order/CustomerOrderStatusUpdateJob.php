<?php

namespace App\Jobs\Order;
use App\Enums\Order\OrderStatusEnum;
use App\Enums\QueuedJobEnum;
use App\Models\Order\Order;
use App\Notifications\V1\Order\CustomerOrderStatusUpdateNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CustomerOrderStatusUpdateJob implements ShouldQueue
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
        $this->order->customer->notify(new CustomerOrderStatusUpdateNotification($this->order));
        if (strtolower($this->order->status) == strtolower(OrderStatusEnum::FULFILLED->value)) {
            HandleMerchantFulfilledOrderJob::dispatch($this->order);
        }
    }
}
