<?php

namespace App\Jobs\V1\Order;
use App\Enums\Order\OrderStatusEnum;
use App\Enums\QueuedJobEnum;
use App\Jobs\V1\Order\HandleMerchantDeliveredOrderJob;
use App\Models\Order\Order;
use App\Notifications\V1\Order\CustomerOrderStatusUpdateNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CustomerOrderStatusUpdateJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct(private Order $order)
  {
    $this->order = $order;
    $this->onQueue(QueuedJobEnum::ORDER->value);
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $order = $this->order;
    $order->customer->notify(new CustomerOrderStatusUpdateNotification($order));
    if(strtolower($order->status) == strtolower(OrderStatusEnum::DELIVERED->value)) {
      HandleMerchantDeliveredOrderJob::dispatch($order);
    }
  }

}
