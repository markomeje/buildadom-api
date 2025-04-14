<?php

namespace App\Notifications\V1\Escrow;
use App\Enums\Queue\QueueEnum;
use App\Traits\CurrencyTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EscrowAccountDebitedNotification extends Notification implements ShouldQueue
{
  use Queueable, CurrencyTrait;

  /**
   * @param float $amount
   * @param float $new_balance
   */
  public function __construct(private float $amount, private float $new_balance)
  {
    $this->onQueue(QueueEnum::ESCROW->value);
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
      ->subject('Escrow Account Debited')
      ->line('Your escrow account has been debited with the sum of ' . $this->formatCurrencyAmount($this->amount) . ' and your new balance is '.$this->formatCurrencyAmount($this->new_balance))
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
