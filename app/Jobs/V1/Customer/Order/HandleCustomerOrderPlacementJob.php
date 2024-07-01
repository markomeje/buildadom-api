<?php

namespace App\Jobs\V1\Customer\Order;
use App\Enums\Queue\QueueEnum;
use App\Notifications\V1\Customer\Order\CustomerPendingOrderNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandleCustomerOrderPlacementJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct(private $orders)
  {
    $this->orders = $orders;
    $this->onQueue(QueueEnum::ORDER->value);
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    foreach($this->orders as $order) {
      $order->customer->notify(new CustomerPendingOrderNotification($order));
    }
  }

}
