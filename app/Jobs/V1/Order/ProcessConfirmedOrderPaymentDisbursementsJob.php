<?php

namespace App\Jobs\V1\Order;
use App\Enums\QueuedJobEnum;
use App\Jobs\V1\Order\HandleConfirmedOrderPaymentJob;
use App\Models\Order\OrderDelivery;
use App\Traits\V1\Escrow\EscrowAccountTrait;
use App\Traits\V1\Order\OrderDeliveryTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessConfirmedOrderPaymentDisbursementsJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, OrderDeliveryTrait, EscrowAccountTrait;

  /**
   * Create a new job instance.
   *
   * @return void
   */
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
    $order_deliveries = OrderDelivery::where(['payment_processed' => 0, 'is_confirmed' => 1, 'payment_authorized' => 1])->get();
    if($order_deliveries->count()) {
      $order_deliveries->map(function ($order_delivery) {
        HandleConfirmedOrderPaymentJob::dispatch($order_delivery);
      });
    }
  }

}
