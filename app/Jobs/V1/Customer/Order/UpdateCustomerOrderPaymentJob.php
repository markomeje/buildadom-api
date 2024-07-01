<?php

namespace App\Jobs\V1\Customer\Order;
use App\Enums\Order\OrderStatusEnum;
use App\Enums\Order\OrderTrackingStatusEnum;
use App\Enums\Payment\PaymentStatusEnum;
use App\Enums\Queue\QueueEnum;
use App\Models\Order\Order;
use App\Models\Order\OrderPayment;
use App\Models\Order\OrderTracking;
use App\Models\Payment\Payment;
use App\Notifications\V1\Merchant\Escrow\MerchantEscrowPaymentConfirmedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateCustomerOrderPaymentJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->onQueue(QueueEnum::PAYMENT->value);
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $orders = Order::where('status', OrderStatusEnum::PENDING->value)->get();
    if ($orders->count()) {
      foreach ($orders as $order) {
        $this->updateOrderPayment($order);
      }
    }
  }

  /**
   * @param Order $order
   */
  private function updateOrderPayment(Order $order)
  {
    $order_payment = OrderPayment::where('order_id', $order->id)->first();
    if(!empty($order_payment)) {
      $payment = Payment::find($order_payment->payment_id);
      if($payment && (strtolower($payment->status) === strtolower(PaymentStatusEnum::SUCCESS->value))) {
        $order->update(['status' => OrderStatusEnum::PAID->value]);
        OrderTracking::create(['order_id' => $order->id, 'status' => OrderTrackingStatusEnum::PROCESSING->value]);
        $order->product->merchant->notify(new MerchantEscrowPaymentConfirmedNotification());
      }
    }
  }

}
