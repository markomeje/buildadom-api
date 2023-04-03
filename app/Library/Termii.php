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
    $config = ['sender_id' => 'Buildadom', 'channel' => 'generic', 'attempts' => 10, 'time_to_live' => 30, 'type' => 'plain'];
    $client = new Client(env('TERMII_API_KEY'), $config);

    $response = $client->sms->send($phone, 'Code - '.$message);
    $response->onError(function ($response) {
      throw new Exception($response['message']);
    });
  }
}



