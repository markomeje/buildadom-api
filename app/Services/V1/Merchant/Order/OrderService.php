<?php

namespace App\Services\V1\Merchant\Order;
use App\Enums\Order\OrderPaymentStatusEnum;
use App\Enums\Order\OrderStatusEnum;
use App\Http\Resources\V1\Order\OrderResource;
use App\Models\Order\Order;
use App\Models\Order\OrderPayment;
use App\Notifications\V1\Order\CustomerOrderStatusUpdateNotification;
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
            $stores = auth()->user()->stores;
            $orders = Order::whereIn('store_id', $stores->pluck('id')->toArray())
                ->whereNotIn('status', [OrderStatusEnum::CANCELLED->value])
                ->with(['currency', 'trackings', 'fulfillment', 'store', 'product' => function ($query) {
                    $query->with(['images', 'category', 'unit', 'currency']);
                }])
                ->latest()
                ->with(['currency', 'payment'])
                ->paginate($request->limit ?? 20);

            return responser()->send(Status::HTTP_OK, OrderResource::collection($orders), 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
        }
    }

    /**
     * @param  int  $id
     */
    public function action($id, Request $request): JsonResponse
    {
        try {
            $order = Order::find($id);
            if (empty($order)) {
                return responser()->send(Status::HTTP_NOT_FOUND, null, 'Order not found');
            }

            $request_status = strtolower($request->status);
            if ($request_status == strtolower(OrderStatusEnum::ACCEPTED->value) && !auth()->user()->bank) {
                throw new Exception('You need to setup your bank details first.', Status::HTTP_NOT_ACCEPTABLE);
            }

            $order_payment = OrderPayment::where(['order_id' => $order->id])->first();
            if (strtolower(optional($order_payment)->status) !== strtolower(OrderPaymentStatusEnum::PAID->value)) {
                return responser()->send(Status::HTTP_NOT_ACCEPTABLE, $order_payment, 'Only paid orders can be acted on.');
            }

            $order_status = strtolower($order->status);
            if ($order_status == strtolower(OrderStatusEnum::DECLINED->value)) {
                return responser()->send(Status::HTTP_NOT_ACCEPTABLE, null, 'You have already declined this order.');
            }

            if ($order_status !== strtolower(OrderStatusEnum::PLACED->value)) {
                return responser()->send(Status::HTTP_NOT_ACCEPTABLE, null, 'Only placed others can be acted on.');
            }

            $order->update(['status' => strtolower($request_status)]);
            $order->customer->notify(new CustomerOrderStatusUpdateNotification($order));

            return responser()->send(Status::HTTP_OK, new OrderResource($order), 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send($e->getCode(), null, $e->getMessage());
        }
    }
}
