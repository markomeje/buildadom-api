<?php

namespace App\Services\V1\Merchant\Order;
use App\Enums\Order\OrderTrackingStatusEnum;
use App\Http\Resources\V1\Customer\Order\OrderResource;
use App\Models\Order\Order;
use App\Models\Order\OrderTracking;
use App\Notifications\V1\Customer\Order\CustomerOrderTrackingNotification;
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
      $orders = Order::owner()->latest()->with(['currency', 'trackings'])->paginate($request->limit ?? 20);
      return Responser::send(Status::HTTP_OK, OrderResource::collection($orders), 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e->getMessage());
    }
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function track($id): JsonResponse
  {
    try {
      $order = Order::with(['trackings'])->findOrFail($id);
      $current_status = strtolower($order->status);

      if($current_status == strtolower(OrderTrackingStatusEnum::DELIVERED->value)) {
        return Responser::send(Status::HTTP_OK, new OrderResource($order), 'Order has been delivered successfully');
      }

      $next_status = $this->getNextTrackingStatus($current_status);
      $order->update(['status' => $next_status]);
      OrderTracking::create(['order_id' => $id, 'status' => $next_status]);

      $order->customer->notify(new CustomerOrderTrackingNotification($order));
      return Responser::send(Status::HTTP_OK, new OrderResource($order->load(['trackings'])), 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

  /**
   * @param string $current_status
   * @return string
   */
  private function getNextTrackingStatus(string $current_status)
  {
    if(in_array($current_status, [OrderTrackingStatusEnum::PROCESSING->value, OrderTrackingStatusEnum::PENDING->value])) {
      $current_status = OrderTrackingStatusEnum::PROCESSED->value;
    }elseif($current_status == OrderTrackingStatusEnum::PROCESSED->value) {
      $current_status = OrderTrackingStatusEnum::DISPATCHED->value;
    }else {
      $current_status = OrderTrackingStatusEnum::DELIVERED->value;
    }

    return $current_status;
  }

}
