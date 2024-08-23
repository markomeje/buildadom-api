<?php

namespace App\Notifications\V1\Order;
use App\Enums\Queue\QueueEnum;
use App\Traits\V1\CurrencyTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerConfirmOrderFulfilledNotification extends Notification implements ShouldQueue
{
  use Queueable, CurrencyTrait;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(private string $tracking_number, private int $confirmation_code)
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
    return (new MailMessage)
      ->subject('Buildadom Order Fulfillment Confirmation Required')
      ->line('Dear valued Customer,')
      ->line("Kindly confirm the fulfillment of order ($this->tracking_number) with the confirmation code below:")
      ->line("Confirmation code: $this->confirmation_code")
      ->line('Thank you for choosing our platform');
  }

}
