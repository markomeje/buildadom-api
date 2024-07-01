<?php

namespace App\Services\V1\Customer\Order;
use App\Http\Resources\V1\Customer\Order\OrderPaymentResource;
use App\Models\Order\OrderPayment;
use App\Services\BaseService;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class OrderPaymentService extends BaseService
{

  public function list(Request $request): JsonResponse
  {
    try {
      $orders = OrderPayment::owner()->latest()->with(['order', 'payment'])->paginate($request->limit ?? 20);
      return Responser::send(Status::HTTP_OK, OrderPaymentResource::collection($orders), 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

}
