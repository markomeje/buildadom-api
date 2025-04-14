<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Payment;
use App\Http\Controllers\Controller;
use App\Services\V1\Payment\PaystackWebhookService;
use Illuminate\Http\Request;

class PaystackWebhookController extends Controller
{
    public function __construct(private PaystackWebhookService $paystackWebhook)
    {
        $this->paystackWebhook = $paystackWebhook;
    }

    /**
     * @return mixed
     */
    public function webhook(Request $request)
    {
        return $this->paystackWebhook->webhook($request);
    }
}
