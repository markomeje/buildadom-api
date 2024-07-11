<?php

namespace App\Services\V1\Payment;
use App\Services\BaseService;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class PaystackWebhookService extends BaseService
{
  /**
   * @return JsonResponse
   */
  public function webhook(Request $request): JsonResponse
  {
    try {
      $server = $request->server();
      if((strtoupper($request->server('REQUEST_METHOD')) !== 'POST') || !array_key_exists('HTTP_X_PAYSTACK_SIGNATURE', $request->server())) {
        exit();
      }

      // Retrieve the request's body
      $input = @file_get_contents("php://input");
      $secret_key = config('services.paystack.secret_key');

      // validate event do all at once to avoid timing attack
      if($request->server('HTTP_X_PAYSTACK_SIGNATURE') !== hash_hmac('sha512', $input, $secret_key)) {
        exit();
      }

      $event = json_decode($input);
      // Do something with $event
      http_response_code(200); // PHP 5.4 or greater

      return Responser::send(Status::HTTP_OK, null, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

}
