<?php

namespace App\Notifications\V1\Order;
use App\Enums\Queue\QueueEnum;
use App\Traits\V1\CurrencyTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerOrderStatusUpdateNotification extends Notification implements ShouldQueue
{
  use Queueable, CurrencyTrait;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(private $order)
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
      ->subject('Buildadom Order Status')
      ->line('Dear valued Customer,')
      ->line("Your order with tracking number $order->tracking_number has been $order->status")
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
