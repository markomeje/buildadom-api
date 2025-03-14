<?php

namespace App\Utility;
use Illuminate\Http\JsonResponse;

class Responser
{
    /**
     * @param int $status
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    public static function send(int $status, mixed $data = null, string $message): JsonResponse
    {
        $info = [
            'status' => $status,
            'data' => $data ?? null,
            'message' => ucfirst($message),
        ];

        return new JsonResponse($info, $status);
    }

}
