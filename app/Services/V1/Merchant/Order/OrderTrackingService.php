<?php

namespace App\Services\V1\Merchant\Order;
use App\Enums\Order\OrderStatusEnum;
use App\Http\Resources\V1\Order\OrderResource;
use App\Jobs\V1\Order\CustomerOrderStatusUpdateJob;
use App\Models\Order\Order;
use App\Models\Order\OrderTracking;
use App\Services\BaseService;
use App\Traits\V1\Order\OrderTrackingTrait;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class OrderTrackingService extends BaseService
{
    use OrderTrackingTrait;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function track(Request $request): JsonResponse
    {
        try {
            $order = Order::with(['trackings'])->where(['tracking_number' => $request->tracking_number])->first();
            if(empty($order)) {
                return responser()->send(Status::HTTP_NOT_FOUND, null, 'Order not found');
            }

            $current_status = strtolower($order->status);
            if($current_status == strtolower(OrderStatusEnum::FULFILLED->value)) {
                return responser()->send(Status::HTTP_OK, new OrderResource($order->load(['trackings'])), 'The Order has already been fulfilled.');
            }

            $this->handleOrderTrackingChecks($current_status);
            $next_status = $this->getNextOrderTrackingStatus($current_status);
            $order->update(['status' => $next_status]);
            OrderTracking::create(['order_id' => $order->id, 'status' => $next_status]);

            CustomerOrderStatusUpdateJob::dispatch($order);
            return responser()->send(Status::HTTP_OK, new OrderResource($order->load(['trackings'])), 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send($e->getCode(), null, $e->getMessage());
        }
    }

}
