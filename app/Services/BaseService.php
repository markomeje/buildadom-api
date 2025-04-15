<?php

namespace App\Services;

class BaseService
{
    public static function generateRandomDigits(): int
    {
        return rand(111111, 999999);
    }
}
