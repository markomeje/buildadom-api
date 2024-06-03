<?php

namespace App\Library;
use Exception;
use App\Interfaces\SmsSenderInterface;
use \ManeOlawale\Termii\Client;

class TermiiSms implements SmsSenderInterface
{
  private string $message;

  private string $phone;

  public array $config;

  private mixed $httpClient;

  public function __construct()
  {
    $this->config = [
      'sender_id' => 'N-Alert',
      'channel' => 'dnd',
      'attempts' => 10,
      'time_to_live' => 30,
      'type' => 'plain'
    ];
  }

  private function setPhone(string $phone): TermiiSms
  {
    $this->phone = formatPhoneNumber($phone);
    return $this;
  }

  private function getTermiiSmsHttpClient()
  {
    $api_key = config('services.termii.api_key');
    return (new Client($api_key, $this->config))->sms;
  }

  private function setMessage(string $message): TermiiSms
  {
    $this->message = $message;
    return $this;
  }

  /**
   * Send sms via Termii API client
   *
   * @return mixed
   *
   */
  public function send()
  {
    try {
      $response = $this->getTermiiSmsHttpClient()->send($this->phone, $this->message);
      $response->onError(function ($response) {
        throw new Exception($response['message']);
      });
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }

    return true;
  }
}
