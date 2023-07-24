<?php

namespace App\Http\Controllers\V1\Customer\Orders;
use Exception;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\V1\Orders\OrderService;


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
   * Add to Order
   *
   * @param Request $request
   */
  public function save(Request $request)
  {
    return $this->orderService->save($request);
  }

  /**
   * @return JsonResponse
   */
  public function details(int $id): JsonResponse
  {
    return $this->orderService->details((int)$id);
  }

  /**
   * @return JsonResponse
   */
  public function orders(): JsonResponse
  {
    return $this->orderService->orders();
  }

  /**
   * @return JsonResponse
   * @param int $id
   */
  public function delete(int $id): JsonResponse
  {
    return $this->OrderService->delete($id);
  }

}
