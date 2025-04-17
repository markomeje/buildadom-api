<?php

namespace App\Traits;
use App\Enums\Cart\CartItemStatusEnum;
use App\Enums\Order\OrderStatusEnum;
use App\Models\Cart\CartItem;
use App\Models\Order\Order;
use App\Notifications\V1\Order\CustomerPendingOrderNotification;
use Exception;

trait OrderTrait
{
    use CurrencyTrait;

    public function generateOrderTrackingNumber(): string
    {
        do {
            $tracking_number = help()->generateRandomDigits(15);
        } while (Order::where('tracking_number', $tracking_number)->exists());

        return $tracking_number;
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    public function createOrder(CartItem $item)
    {
        $product = $item->product;
        if (empty($product)) {
            throw new Exception('Invalid cart product');
        }

        $quantity = (int) ($item->quantity ?? 1);
        $price = (float) $product->price;
        $total_amount = (float) ($price * $quantity);
        $customer_id = auth()->id();

        $product_id = $item->product_id;

        $order = Order::updateOrCreate([
            'product_id' => $product_id,
            'status' => OrderStatusEnum::PENDING->value,
            'customer_id' => $customer_id,
        ], [
            'total_amount' => $total_amount,
            'product_id' => $product_id,
            'status' => OrderStatusEnum::PENDING->value,
            'customer_id' => $customer_id,
            'store_id' => $product->store_id,
            'currency_id' => $this->getDefaultCurrency()->id,
            'tracking_number' => $this->generateOrderTrackingNumber(),
            'quantity' => $quantity,
            'amount' => $price,
        ]);

        $order->customer->notify(new CustomerPendingOrderNotification($order, $product));
        $item->update(['status' => CartItemStatusEnum::PROCESSED->value]);
    }
}
