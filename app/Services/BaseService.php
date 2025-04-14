<?php

declare(strict_types=1);

namespace App\Services;

class BaseService
{
    public static function generateRandomDigits(): int
    {
        return rand(111111, 999999);
    }
}
