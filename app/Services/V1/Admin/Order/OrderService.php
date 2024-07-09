<?php

namespace App\Services\V1\Admin\Order;
use App\Http\Resources\V1\Order\OrderResource;
use App\Models\Order\Order;
use App\Services\BaseService;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class OrderService extends BaseService
{

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function list(Request $request): JsonResponse
  {
    try {
      $orders = Order::latest()->with(['trackings', 'delivery', 'currency'])->paginate($request->limit ?? 20);
      return Responser::send(Status::HTTP_OK, $orders, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
    }
  }

}
