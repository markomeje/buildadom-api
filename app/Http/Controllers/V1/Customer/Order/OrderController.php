<?php

namespace App\Http\Controllers\V1\Customer\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Customer\Order\CreateCustomerOrderRequest;
use App\Services\V1\Customer\Order\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @param \App\Services\V1\Customer\Order\OrderService $orderService
     */
    public function __construct(public OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @param \App\Http\Requests\V1\Customer\Order\CreateCustomerOrderRequest $request
     * @return JsonResponse
     */
    public function create(CreateCustomerOrderRequest $request): JsonResponse
    {
        return $this->orderService->create($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        return $this->orderService->list($request);
    }

    /**
     * @param mixed $id
     * @return JsonResponse
     */
    public function trackings($id): JsonResponse
    {
        return $this->orderService->trackings($id);
    }

    /**
     * @param mixed $id
     * @return JsonResponse
     */
    public function cancel($id): JsonResponse
    {
        return $this->orderService->cancel($id);
    }

    /**
     * @param mixed $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        return $this->orderService->delete($id);
    }

    /**
     * @return JsonResponse
     */
    public function driver(): JsonResponse
    {
        return $this->orderService->driver();
    }
}
