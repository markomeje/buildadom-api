<?php

declare(strict_types=1);

namespace App\Notifications\V1\Order;
use App\Enums\Queue\QueueEnum;
use App\Models\Order\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MerchantFulfilledOrderConfirmedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private Order $order)
    {
        $this->onQueue(QueueEnum::ORDER->value);
    }

    /**
     * Get the notification's fulfillment channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $tracking_number = $this->order->tracking_number;

        return (new MailMessage)
            ->subject('Buildadom Order fulfillment Confirmation')
            ->line("Your fulfillment of the order with tracking number {$tracking_number} has been confirmed.")
            ->line('Thank you for choosing our platform');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [];
    }
}
