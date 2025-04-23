<?php

namespace App\Partners;
use App\Contracts\SmsSenderInterface;
use App\Exceptions\SendSmsException;
use Exception;
use ManeOlawale\Termii\Client;

class TermiiSmsProvider implements SmsSenderInterface
{
    /**
     * @var string
     */
    private string $message;

    /**
     * @var string
     */
    private string $phone;

    /**
     * @return array
     */
    public function getConfig()
    {
        return [
            'sender_id' => config('services.termii.sender_id'),
            'channel' => config('services.termii.channel'),
            'attempts' => config('services.termii.attempts'),
            'time_to_live' => config('services.termii.time_to_live'),
            'type' => config('services.termii.type'),
        ];
    }

    /**
     * @param  string  $phone
     * @return self
     */
    public function setPhone(string $phone): self
    {
        $this->phone = formatPhoneNumber($phone);
        return $this;
    }

    /**
     * @param  string  $message
     * @return self
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @throws \App\Exceptions\SendSmsException
     * @throws Exception
     *
     * @return bool
     */
    public function send()
    {
        try {
            $response = $this->client()->send($this->phone, $this->message);
            $response->onError(fn ($response) => throw new SendSmsException($response['message']));
        } catch (SendSmsException $e) {
            throw new SendSmsException($e->getMessage());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return true;
    }

    /**
     * @return \ManeOlawale\Termii\Api\Sms
     */
    private function client()
    {
        $api_key = config('services.termii.api_key');
        $client = new Client($api_key, $this->getConfig());
        return $client->sms;
    }
}
