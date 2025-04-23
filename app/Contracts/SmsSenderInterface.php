<?php

namespace App\Contracts;
use Exception;

interface SmsSenderInterface
{
    /**
     * @throws \App\Exceptions\SendSmsException
     * @throws Exception
     * @return bool
     */
    public function send();

    /**
     * @return array
     */
    public function getConfig();

    /**
     * @param  string  $phone
     * @return self
     */
    public function setPhone(string $phone): self;

    /**
     * @param  string  $message
     * @return self
     */
    public function setMessage(string $message): self;

}
