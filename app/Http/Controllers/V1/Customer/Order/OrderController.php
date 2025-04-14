<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Customer\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Customer\Order\CreateCustomerOrderRequest;
use App\Services\V1\Customer\Order\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(public OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function create(CreateCustomerOrderRequest $request): JsonResponse
    {
        return $this->orderService->create($request);
    }

    public function list(Request $request): JsonResponse
    {
        return $this->orderService->list($request);
    }

    public function trackings($id): JsonResponse
    {
        return $this->orderService->trackings($id);
    }

    /**
     * @param  int  $id
     */
    public function cancel($id): JsonResponse
    {
        return $this->orderService->cancel($id);
    }

    /**
     * @param  int  $id
     */
    public function delete($id): JsonResponse
    {
        return $this->orderService->delete($id);
    }
}
