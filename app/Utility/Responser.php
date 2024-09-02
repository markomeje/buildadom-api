<?php

namespace App\Utility;
use Illuminate\Http\JsonResponse;



class Responser
{
  /**
   * Return a new JSON response with mixed(object|JsonSerializable) data
   *
   * @param int $status
   * @param mixed $data
   * @param mixed $error
   *
   * @return JsonResponse
   */
  public static function send(int $status, mixed $data = null, string $message, $error = null): JsonResponse
  {
    return new JsonResponse([
        'status' => $status,
        'data' => $data,
        'message' => ucfirst($message),
      ],
      $status,
    );
  }
}
