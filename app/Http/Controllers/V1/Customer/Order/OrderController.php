<?php

namespace App\Http\Controllers\V1\Customer\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Customer\Order\CreateCustomerOrderRequest;
use App\Services\V1\Customer\Order\OrderService;
use Illuminate\Http\JsonResponse;


class OrderController extends Controller
{

  /**
   * @param OrderService $orderService
   */
  public function __construct(public OrderService $orderService)
  {
    $this->orderService = $orderService;
  }

  /**
   * @param CreateCustomerOrderRequest $request
   * @return JsonResponse
   */
  public function create(CreateCustomerOrderRequest $request): JsonResponse
  {
    return $this->orderService->create($request);
  }

  /**
   * @return JsonResponse
   */
  public function list(): JsonResponse
  {
    return $this->orderService->list();
  }

  /**
   * @return JsonResponse
   */
  public function trackings($id): JsonResponse
  {
    return $this->orderService->trackings($id);
  }

}
