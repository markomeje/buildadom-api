<?php

namespace App\Jobs\V1\Order;
use App\Enums\Queue\QueueEnum;
use App\Models\Order\Order;
use App\Notifications\V1\Order\CustomerPendingOrderReminderNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CustomerPendingOrderReminderJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->onQueue(QueueEnum::ORDER->value);
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $orders = Order::isPending()->where('created_at', '>', now()->subDay())->get();
    if($orders->count()) {
      foreach ($orders as $order) {
        $order->customer->notify(new CustomerPendingOrderReminderNotification($order));
      }
    }
  }

}
