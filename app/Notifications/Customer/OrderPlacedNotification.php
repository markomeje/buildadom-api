<?php

namespace App\Notifications\Customer;
use App\Enums\Queue\QueueEnum;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlacedNotification extends Notification implements ShouldQueue
{
  use Queueable;

  /**
   * @var array
   */
  private $tracking_numbers;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(array $tracking_numbers)
  {
    $this->tracking_numbers = $tracking_numbers;
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
    $start_delivery_date = Carbon::today()->format('M d Y');
    $end_delivery_date = Carbon::today()->addDays(5)->format('M d Y');
    $tracking_numbers = implode(', ', $this->tracking_numbers);

    return (new MailMessage)
      ->subject('Buildadom Order Placed Successfully')
      ->line("Your order has been placed with a delivery duration between $start_delivery_date to $end_delivery_date")
      ->line("Tracking number(s) $tracking_numbers")
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
