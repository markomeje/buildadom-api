<?php


namespace App\Services;
use Illuminate\Http\JsonResponse;


class BaseService
{

  /**
   *
   */
  public function successResponse(array $data = [], string $message = '', int $code = 200): JsonResponse
  {
    return response()->json([
      'success' => true,
      'message' => $message ? $message : 'Operation successful',
      'data' => $data,
    ], $code);
  }

  /**
   *
   */
  public function errorResponse(string $message, $code = 500): JsonResponse
  {
    return response()->json([
      'success' => false,
      'message' => $message ? $message : 'Operation failed',
    ], $code);
  }

}
