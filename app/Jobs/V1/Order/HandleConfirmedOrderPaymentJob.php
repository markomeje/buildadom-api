<?php

namespace App\Jobs\V1\Order;
use App\Enums\QueuedJobEnum;
use App\Jobs\V1\Escrow\DebitEscrowAccountJob;
use App\Jobs\V1\Payment\InitializeTransferPaymentJob;
use App\Models\Order\OrderFulfillment;
use App\Traits\V1\Escrow\EscrowAccountTrait;
use App\Traits\V1\Order\OrderFulfillmentTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandleConfirmedOrderPaymentJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, OrderFulfillmentTrait, EscrowAccountTrait;

  /**
   * Create a new job instance.
   *
   * @return void
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
    $amount = (float)$order->total_amount;

    DebitEscrowAccountJob::dispatch($order->customer, $amount);
    InitializeTransferPaymentJob::dispatch($order->store->merchant, $this->order_fulfillment->reference, $amount);
    $this->order_fulfillment->update(['payment_processed' => 1]);
  }

}
