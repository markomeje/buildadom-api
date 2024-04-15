<?php

namespace App\Http\Controllers\V1\Merchant\Order;
use App\Http\Controllers\Controller;
use App\Services\V1\Merchant\Order\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class OrderController extends Controller
{
  /**
   * @param OrderService $OrderService
   */
  public function __construct(public OrderService $orderService)
  {
    $this->orderService = $orderService;
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function list(Request $request): JsonResponse
  {
    return $this->orderService->list($request);
  }

}
