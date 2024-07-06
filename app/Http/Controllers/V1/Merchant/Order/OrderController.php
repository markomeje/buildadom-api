<?php

namespace App\Http\Controllers\V1\Merchant\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Order\MerchantOrderActionRequest;
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

  /**
   * @param int $id
   * @param MerchantOrderActionRequest $request
   * @return JsonResponse
   */
  public function action($id, MerchantOrderActionRequest $request): JsonResponse
  {
    return $this->orderService->action($id, $request);
  }

}
