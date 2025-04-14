<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Customer\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Customer\Order\InitializeOrderPaymentRequest;
use App\Services\V1\Customer\Order\OrderPaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderPaymentController extends Controller
{
    /**
     * @param  OrderPaymentService  $orderService
     */
    public function __construct(public OrderPaymentService $orderPaymentService)
    {
        $this->orderPaymentService = $orderPaymentService;
    }

    public function initialize(InitializeOrderPaymentRequest $request): JsonResponse
    {
        return $this->orderPaymentService->initialize($request);
    }

    public function list(Request $request): JsonResponse
    {
        return $this->orderPaymentService->list($request);
    }
}
