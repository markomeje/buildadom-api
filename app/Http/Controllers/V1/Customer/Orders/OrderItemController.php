<?php

namespace App\Http\Controllers\V1\Customer\Orders;
use Exception;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\V1\Orders\OrderItemService;


class OrderItemController extends Controller
{

  /**
   * @param OrderItemService $OrderItemService
   */
  public function __construct(public OrderItemService $orderItemService)
  {
    $this->orderItemService = $orderItemService;
  }

  /**
   *
   * @param TrackOrderStatusRequest $request
   * @return JsonResponse
   */
  public function items(): JsonResponse
  {
    return $this->orderItemService->items();
  }

}