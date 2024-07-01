<?php

namespace App\Notifications\V1\Customer\Order;
use App\Enums\Queue\QueueEnum;
use App\Traits\V1\CurrencyTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerPendingOrderNotification extends Notification implements ShouldQueue
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
   * Get the notification's delivery channels.
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
      ->subject('Buildadom Order Placed Successfully')
      ->line('Dear valued Customer,')
      ->line('We are excited to let you know that your order has been successfully placed and is now in the processing stage.')
      ->line('Your order details are listed below.')
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
