<?php

namespace App\Contracts;

interface SmsSenderInterface
{
    /**
     * @throws \App\Exceptions\SendSmsException
     * @throws \Exception
     * @return bool
     */
    public function send();

    /**
     * @return array
     */
    public function getConfig();
}
