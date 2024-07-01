<?php

namespace App\Notifications\V1\Admin\Kyc;
use App\Enums\Queue\QueueEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminKycActionNotification extends Notification implements ShouldQueue
{
  use Queueable;

  /**
   * @var string
   */
  private $kyc_status;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct($kyc_status)
  {
    $this->kyc_status = $kyc_status;
    $this->onQueue(QueueEnum::EMAIL->value);
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
    $kyc_status = $this->kyc_status;
    $mail = (new MailMessage)->subject('Buildadom KYC Verification Update');
    $this->getKycStatusMailMessage($kyc_status, $mail);
    return $mail;
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

  /**
   * @param $kyc_status,
   * @param $mail
   * @return mixed
   */
  private function getKycStatusMailMessage($kyc_status, $mail)
  {
    switch ($kyc_status) {
      case 'verified':
        $mail->line('Your Kyc verification was successful.');
        break;
      case 'failed':
        $mail->line('Your Kyc verification failed. Kindly start the process again.');
        break;
      case 'invalid':
        $mail->line('Your Kyc verification is invalid. Kindly start the process again.');
        break;
      default:
        $mail->line('Your Kyc verification is invalid. Kindly start the process again.');
        break;
    }

    $mail->line('Thank you for choosing our platform');
  }
}
