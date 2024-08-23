<?php

namespace App\Services\V1\Payment;
use App\Jobs\LogDeveloperInfoJob;
use App\Models\Payment\Payment;
use App\Services\BaseService;
use Exception;
use Illuminate\Http\Request;


class PaystackWebhookService extends BaseService
{
  /**
   * @param Request $request
   * @return mixed
   */
  public function webhook(Request $request)
  {
    try {
      if((strtolower($request->server('REQUEST_METHOD')) !== 'post')) {
        LogDeveloperInfoJob::dispatch("Invalid paystack webhook request method");
        exit();
      }

      if(!array_key_exists('HTTP_X_PAYSTACK_SIGNATURE', $request->server())) {
        LogDeveloperInfoJob::dispatch("Invalid paystack http server signature");
        exit();
      }

      $input = @file_get_contents("php://input");
      if($request->server('HTTP_X_PAYSTACK_SIGNATURE') !== hash_hmac('sha512', $input, config('services.paystack.secret_key'))) {
        LogDeveloperInfoJob::dispatch("Invalid paystack signature");
        exit();
      }

      $payload = json_decode($input, true, 512);
      $paystack = $payload['data'];

      $payment = Payment::where(['reference' => $paystack['reference']])->first();
      LogDeveloperInfoJob::dispatch(json_encode(['payment' => $payment, 'payload' => $payload, 'paystack' => $paystack]));
      if(empty($payment)) {
        LogDeveloperInfoJob::dispatch("Invalid paystack payment reference");
        exit();
      }

      $data = ['status' => $paystack['status'], 'webhook_response' => $payload];
      if(in_array($payload['event'], $this->events()['transfer'])) {
        $data = array_merge($data, ['transfer_code' => $paystack['transfer_code']]);
      }

      $payment->update($data);
      http_response_code(200);
    } catch (Exception $e) {
      LogDeveloperInfoJob::dispatch($e->getMessage());
      exit();
    }
  }

  /**
   * @return array
   */
  private function events()
  {
    return [
      'transfer' => [
        'transfer.failed',
        'transfer.success',
        'transfer.reversed',
      ],
      'charge' => [
        'charge.success',
      ]
    ];
  }

}
