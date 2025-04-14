<?php

namespace App\Services\V1\Payment;
use App\Jobs\LogDeveloperInfoJob;
use App\Jobs\Payment\HandlePaystackWebhookEventJob;
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
            if(strtolower($request->server('REQUEST_METHOD')) !== 'post') {
                LogDeveloperInfoJob::dispatch('Invalid paystack webhook request method');
                exit();
            }

            if(!array_key_exists('HTTP_X_PAYSTACK_SIGNATURE', $request->server())) {
                LogDeveloperInfoJob::dispatch('Invalid paystack http server signature');
                exit();
            }

            $input = @file_get_contents("php://input");
            if($request->server('HTTP_X_PAYSTACK_SIGNATURE') !== hash_hmac('sha512', $input, config('services.paystack.secret_key'))) {
                LogDeveloperInfoJob::dispatch('Invalid paystack signature');
                exit();
            }

            $payload = json_decode($input, true, 512);
            HandlePaystackWebhookEventJob::dispatch($payload);

            LogDeveloperInfoJob::dispatch('Paystack webhook event recieved successfully.');
            http_response_code(200);
        } catch (Exception $e) {
            LogDeveloperInfoJob::dispatch('PAYSTACK WEBHOOK EXCEPTION - '.$e->getMessage());
            exit();
        }
    }

}
