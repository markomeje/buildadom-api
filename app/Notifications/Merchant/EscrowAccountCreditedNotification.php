<?php

namespace App\Notifications\Merchant;
use App\Enums\Queue\QueueEnum;
use App\Traits\CurrencyTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EscrowAccountCreditedNotification extends Notification implements ShouldQueue
{
  use Queueable, CurrencyTrait;

  /**
   * @var float
   */
  private $total_amount;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct($total_amount)
  {
    $this->total_amount = $total_amount;
    $this->onQueue(QueueEnum::ESCROW->value);
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
    $total_amount = 'NGN'.number_format($this->total_amount);
    return (new MailMessage)
      ->subject('Buildadom Escrow Account credited.')
      ->line("Your escrow account has been credited with the sum of $total_amount and will be disbursed to the respective merchant(s) after your order(s) has been fulfilled.")
      ->line('Incase of an questions, kindly contact our support.')
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