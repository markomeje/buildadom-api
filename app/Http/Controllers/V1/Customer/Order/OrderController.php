<?php

namespace App\Http\Controllers\V1\Customer\Order;
use App\Http\Controllers\Controller;
use App\Services\V1\Customer\Order\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


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
   * @return JsonResponse
   */
  public function create(): JsonResponse
  {
    return $this->orderService->create();
  }

  /**
   * @return JsonResponse
   */
  public function list(): JsonResponse
  {
    return $this->orderService->list();
  }

}
