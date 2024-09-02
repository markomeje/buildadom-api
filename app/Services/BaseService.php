<?php


namespace App\Services;
use Illuminate\Http\JsonResponse;


class BaseService
{

  public static function generateRandomDigits(): int
  {
    return rand(111111, 999999);
  }
}
