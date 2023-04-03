<?php

namespace App\Interfaces;


interface SmsInterface
{
  /**
   * Any sms class must have a send method
   * @return void
   * @param string $phone string $message
   */
  public static function send(string $phone, string $message): void;
}
