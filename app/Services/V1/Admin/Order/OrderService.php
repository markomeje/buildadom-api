<?php

namespace App\Services\V1\Admin\Order;
use App\Models\Order\Order;
use App\Services\BaseService;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderService extends BaseService
{
    public function list(Request $request): JsonResponse
    {
        try {
            $orders = Order::latest()->with(['trackings', 'fulfillment', 'currency'])->paginate($request->limit ?? 20);

            return responser()->send(Status::HTTP_OK, $orders, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
        }
    }
}
