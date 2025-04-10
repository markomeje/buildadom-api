<?php

namespace App\Integrations;
use \ManeOlawale\Termii\Client;
use App\Interfaces\SmsSenderInterface;
use Exception;

class TermiiSms implements SmsSenderInterface
{
    private string $message;

    private string $phone;

    public array $config;

    public function __construct()
    {
        $this->config = [
            'sender_id' => config('services.termii.sender_id'),
            'channel' => 'dnd',
            'attempts' => 10,
            'time_to_live' => 30,
            'type' => 'plain'
        ];
    }

    public function setPhone(string $phone): self
    {
        $this->phone = formatPhoneNumber($phone);
        return $this;
    }

    private function getHttpClient()
    {
        $api_key = config('services.termii.api_key');
        return (new Client($api_key, $this->config))->sms;
    }

    public function setMessage(string $message): self
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
            $response = $this->getHttpClient()->send($this->phone, $this->message);
            $response->onError(function ($response) {
                throw new Exception($response['message']);
            });

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return true;
    }

}
