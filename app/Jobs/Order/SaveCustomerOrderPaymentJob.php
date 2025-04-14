<?php

namespace App\Jobs\Order;
use App\Enums\Order\OrderPaymentStatusEnum;
use App\Enums\QueuedJobEnum;
use App\Models\Order\OrderPayment;
use App\Models\Payment\Payment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveCustomerOrderPaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param \Illuminate\Database\Eloquent\Collection $orders
     * @param \App\Models\User $customer
     * @param \App\Models\Payment\Payment $payment
     */
    public function __construct(private Collection $orders, private User $customer, private Payment $payment)
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
        foreach ($this->orders as $order) {
            $order_id = $order->id;
            OrderPayment::updateOrCreate(['order_id' => $order_id], [
                'order_id' => $order_id,
                'customer_id' => $this->customer->id,
                'payment_id' => $this->payment->id,
                'status' => OrderPaymentStatusEnum::PENDING->value
            ]);
        }
    }

}
