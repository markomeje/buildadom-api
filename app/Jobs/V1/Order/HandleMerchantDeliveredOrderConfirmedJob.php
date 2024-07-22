<?php

namespace App\Jobs\V1\Order;
use App\Enums\QueuedJobEnum;
use App\Models\Order\OrderDelivery;
use App\Notifications\V1\Order\MerchantDeliveredOrderConfirmedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandleMerchantDeliveredOrderConfirmedJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct(private OrderDelivery $order_delivery)
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
    $order = $this->order_delivery->order;
    $order->store->merchant->notify(new MerchantDeliveredOrderConfirmedNotification($order->tracking_number));
    ProcessConfirmedOrderPaymentDisbursementsJob::dispatch($this->order_delivery);
  }

}
