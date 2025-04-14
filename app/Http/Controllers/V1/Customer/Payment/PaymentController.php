<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Customer\Payment;
use App\Http\Controllers\Controller;
use App\Services\V1\Customer\Payment\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function list(Request $request): JsonResponse
    {
        return $this->paymentService->list($request);
    }
}
