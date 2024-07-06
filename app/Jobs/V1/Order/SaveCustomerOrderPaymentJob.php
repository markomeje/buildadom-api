<?php

namespace App\Jobs\V1\Order;
use App\Enums\Order\OrderPaymentStatusEnum;
use App\Enums\Queue\QueueEnum;
use App\Models\Order\OrderPayment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveCustomerOrderPaymentJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct(private $orders, private $customer_id, private $payment_id)
  {
    $this->orders = $orders;
    $this->customer_id = $customer_id;
    $this->payment_id = $payment_id;
    $this->onQueue(QueueEnum::ORDER->value);
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    foreach ($this->orders as $order) {
      $order_id = $order->id;
      OrderPayment::updateOrCreate(['order_id' => $order_id], [
        'order_id' => $order_id,
        'payment_id' => $this->payment_id,
        'customer_id' => $this->customer_id,
        'status' => OrderPaymentStatusEnum::PENDING->value
      ]);
    }
  }

}
