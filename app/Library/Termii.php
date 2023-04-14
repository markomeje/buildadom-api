<?php

namespace App\Library;
use \ManeOlawale\Termii\Client;
use App\Interfaces\SmsInterface;
use Exception;

class Termii implements SmsInterface
{

  /**
   * Send sms via Termii API client
   * @param $phone, $message
   *
   */
  public static function send(string $phone, string $message): void
  {
    $senderId = env('TERMII_SENDER_ID');
    $config = ['sender_id' => 'N-Alert', 'channel' => 'dnd', 'attempts' => 10, 'time_to_live' => 30, 'type' => 'plain'];

    $response = (new Client(env('TERMII_API_KEY'), $config))->sms->send($phone, "Your {$senderId} confirmation code is {$message}");
    $response->onError(function ($response) {
      throw new Exception($response['message']);
    });
  }
}



