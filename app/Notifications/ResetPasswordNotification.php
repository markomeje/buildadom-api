<?php

namespace App\Notifications;
use App\Enums\QueuedJobEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordNotification extends Notification implements ShouldQueue
{
  use Queueable;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(private int $code)
  {
    $this->onQueue(QueuedJobEnum::EMAIL->value);
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
      ->subject('Password Reset Request')
      ->line('You are receiving this email because we received a password reset request for your account. Kindly use the code below to reset your password.')
      ->line($this->code)
      ->line('If you did not request a password reset, no further action is required.')
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
    return [
      //
    ];
  }
}
