<?php

namespace App\Services\V1\Merchant\Order;
use App\Enums\Order\OrderStatusEnum;
use App\Exceptions\OrderTrackingException;
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
                return responser()->send(Status::HTTP_OK, new OrderResource($order->load(['trackings'])), 'The order has already been fulfilled.');
            }

            if($current_status == strtolower(OrderStatusEnum::DECLINED->value)) {
                throw new OrderTrackingException('Order has already been declined.');
            }elseif($current_status == strtolower(OrderStatusEnum::PLACED->value)) {
                throw new OrderTrackingException('You need to accept or decline the order first.');
            }

            $next_status = $this->getNextOrderTrackingStatus($current_status);
            $order->update(['status' => $next_status]);
            OrderTracking::create(['order_id' => $order->id, 'status' => $next_status]);

            CustomerOrderStatusUpdateJob::dispatch($order);
            return responser()->send(Status::HTTP_OK, new OrderResource($order->load(['trackings'])), 'Operation successful.');
        } catch(OrderTrackingException $t) {
            return responser()->send(Status::HTTP_NOT_ACCEPTABLE, [], $t->getMessage());
        } catch (Exception) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Order tracking failed. Try again.');
        }
    }

}
