<?php

declare(strict_types=1);

namespace App\Interfaces;

interface SmsSenderInterface
{
    /**
     * Any sms class must have a send method
     *
     * @param  string  $phone  string $message
     * @return mixed
     */
    public function send();
}
