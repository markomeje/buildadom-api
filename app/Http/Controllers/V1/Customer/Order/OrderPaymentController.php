<?php

namespace App\Http\Controllers\V1\Customer\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Customer\Order\InitializeOrderPaymentRequest;
use App\Services\V1\Customer\Order\OrderPaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderPaymentController extends Controller
{
    /**
     * @param \App\Services\V1\Customer\Order\OrderPaymentService $orderPaymentService
     */
    public function __construct(public OrderPaymentService $orderPaymentService)
    {
        $this->orderPaymentService = $orderPaymentService;
    }

    /**
     * @param \App\Http\Requests\V1\Customer\Order\InitializeOrderPaymentRequest $request
     * @return JsonResponse
     */
    public function initialize(InitializeOrderPaymentRequest $request): JsonResponse
    {
        return $this->orderPaymentService->initialize($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        return $this->orderPaymentService->list($request);
    }
}
