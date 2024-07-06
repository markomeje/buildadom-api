<?php

namespace App\Jobs\V1\Order;
use App\Enums\Queue\QueueEnum;
use App\Models\Order\Order;
use App\Notifications\V1\Order\CustomerConfirmOrderDeliveryNotification;
use App\Traits\V1\Order\OrderDeliveryTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandleMerchantDeliveredOrderJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, OrderDeliveryTrait;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct(private Order $order)
  {
    $this->order = $order;
    $this->onQueue(QueueEnum::ORDER->value);
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $confirmation_code = help()->generateRandomDigits(6);
    $this->saveOrderDelivery($this->order, $confirmation_code);
    $this->order->customer->notify(new CustomerConfirmOrderDeliveryNotification($this->order->tracking_number, $confirmation_code));
  }

}
