<?php

namespace App\Jobs\V1;
use App\Enums\Order\OrderStatusEnum;
use App\Enums\Payment\PaymentStatusEnum;
use App\Models\Order\Order;
use App\Models\Order\OrderPayment;
use App\Models\Payment\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateOrderPaymentJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->onQueue(config('constants.queue.payment'));
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $orders = Order::where('status', OrderStatusEnum::PENDING->value)->get();
    if (empty($orders->count())) {
      return;
    }

    foreach ($orders as $order) {
      $order_payment = OrderPayment::where('order_id', $order->id)->first();
      if(!empty($order_payment)) {

        $payment = Payment::find($order_payment->payment_id);
        if($payment && (strtolower($payment->status) == strtolower(PaymentStatusEnum::SUCCESS->value))) {
          $order->update(['status' => OrderStatusEnum::PAID->value]);
        }
      }
    }
  }

}
