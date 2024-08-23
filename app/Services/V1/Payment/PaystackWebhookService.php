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
      $payload = $request->all();
      if((strtolower($request->server('REQUEST_METHOD')) !== 'post')) {
        LogDeveloperInfoJob::dispatch("Invalid paystack webhook request method");
        exit();
      }

      if(!array_key_exists('HTTP_X_PAYSTACK_SIGNATURE', $request->server())) {
        LogDeveloperInfoJob::dispatch("Invalid paystack http server signature");
        exit();
      }

      if($request->server('HTTP_X_PAYSTACK_SIGNATURE') !== hash_hmac('sha512', json_encode($payload), config('services.paystack.secret_key'))) {
        LogDeveloperInfoJob::dispatch("Invalid paystack signature");
        exit();
      }

      $paystack = $payload['data'];
      $payment = Payment::where('reference', $paystack['reference'] ?? null)->first();
      if(empty($payment)) {
        LogDeveloperInfoJob::dispatch("Invalid paystack payment reference");
        exit();
      }

      $data = ['status' => $paystack['status'], 'webhook_response' => $paystack];
      if(in_array($payload['event'], $this->events()['transfer'])) {
        $data = array_merge($data, ['transfer_code' => $paystack['transfer_code']]);
      }

      $payment->update($data);
      http_response_code(200);
    } catch (Exception $e) {
      $message = $e->getMessage();
      LogDeveloperInfoJob::dispatch("An exception from Paystack webhook - $message");
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
