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
}
