<?php

namespace App\Http\Controllers\V1\Customer\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Customer\Order\ConfirmOrderFulfillmentRequest;
use App\Services\V1\Customer\Order\OrderFulfillmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderFulfillmentController extends Controller
{
    public function __construct(public OrderFulfillmentService $orderFulfillmentService)
    {
        $this->orderFulfillmentService = $orderFulfillmentService;
    }

    public function confirm(ConfirmOrderFulfillmentRequest $request): JsonResponse
    {
        return $this->orderFulfillmentService->confirm($request);
    }

    public function list(Request $request): JsonResponse
    {
        return $this->orderFulfillmentService->list($request);
    }
}
