<?php

namespace App\Jobs\Order;
use App\Enums\Order\OrderPaymentStatusEnum;
use App\Enums\Order\OrderStatusEnum;
use App\Enums\Payment\PaymentStatusEnum;
use App\Enums\QueuedJobEnum;
use App\Models\Order\Order;
use App\Models\Order\OrderPayment;
use App\Notifications\V1\Order\MerchantOrderPlacedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateCustomerOrderPaymentDetailsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

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
        $orders = Order::where('status', OrderStatusEnum::PENDING->value)->get();
        if ($orders->count()) {
            $orders->map(function ($order) {
                $this->updateOrderPayment($order);
            });
        }
    }

    private function updateOrderPayment(Order $order)
    {
        $order_payment = OrderPayment::where('order_id', $order->id)->first();
        if (!empty($order_payment)) {
            $payment = $order_payment->payment;
            if ($payment && (strtolower($payment->status) == strtolower(PaymentStatusEnum::SUCCESS->value))) {
                $order_payment->update(['status' => OrderPaymentStatusEnum::PAID->value]);

                $order->update(['status' => OrderStatusEnum::PLACED->value]);
                $order->store->merchant->notify(new MerchantOrderPlacedNotification);
            }
        }
    }
}
