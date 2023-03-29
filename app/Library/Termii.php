<?php

namespace App\Library;
use \ManeOlawale\Termii\Client;
use Exception;

class Termii 
{
  /**
   * Sms client
   */
  private $client;

  /**
   *
   * @return void
   */
  public function __construct($phone = '', $message = '')
  {
    $this->phone = $phone;
    $this->message = $message;
    $this->client = new Client(env('TERMII_API_KEY'), [
      'sender_id' => 'Buildadom',
      'channel' => 'generic',
      "attempts" => 10,
      "time_to_live" => 30,
      'pin_type' => 'ALPHANUMERIC',
      'message_type' => 'ALPHANUMERIC',
      'type' => 'plain',
    ]);
  }

  /**
   * Instantiates the sms facade
   */
  public static function sms($data = [])
  {
    return (new Termii($data['phone'], $data['message']));
  }

  public function send()
  {
    $response = $this->client->sms->send($this->phone, $this->message);
    $response->onError(function ($response) {
      throw new Exception($response);
    });

    // if ($response->failed()) {
    //   throw new Exception('Sending sms failed. Try again');
    // }
  }
}



