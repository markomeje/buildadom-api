<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetNotification extends Notification
{
    use Queueable;

    /**
     * The SMS code
     */
    private $code;

    /**
     * The TYpe of reset
     */
    private $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($code, $type = 'password')
    {
        $this->code = $code;
        $this->type = $type;
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
        $type = ucfirst($this->type);
        return (new MailMessage)
                    ->subject("{$type} Reset code")
                    ->line("Please use the code below to reset your {$type}")
                    ->line($this->code)
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
