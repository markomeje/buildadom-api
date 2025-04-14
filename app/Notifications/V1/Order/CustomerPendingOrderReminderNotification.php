<?php

namespace App\Notifications\V1\Order;
use App\Enums\Queue\QueueEnum;
use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Traits\CurrencyTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerPendingOrderReminderNotification extends Notification implements ShouldQueue
{
  use Queueable, CurrencyTrait;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(private Order $order)
  {
    $this->order = $order;
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
    $order = $this->order;
    return (new MailMessage)
      ->subject('Buildadom Pending Order Reminder')
      ->line('Dear valued Customer,')
      ->line('Your order is still pending. If you do not wish to proceed with the order, kindly cancel it.')
      ->line("Tracking number: ". $order->tracking_number)
      ->line("Amount: ". $this->getDefaultCurrency()->code.number_format($order->amount))
      ->line("Quantity: ". $order->quantity)
      ->line("Total Amount: ". $this->getDefaultCurrency()->code.number_format($order->total_amount))
      ->line("Status: ". strtoupper($order->status))
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
