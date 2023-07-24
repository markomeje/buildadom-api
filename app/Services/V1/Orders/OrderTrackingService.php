<?php

namespace App\Services\V1\Orders;
use App\Models\V1;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Http\JsonResponse;
use App\Models\V1\Orders\OrderItem;
use App\Models\V1\Orders\OrderTracking;
use App\Enums\V1\Order\OrderTrackingStatusEnum;

class OrderTrackingService extends BaseService
{

  public function __construct(public OrderTracking $orderTracking, public OrderItem $orderItem)
  {
    $this->orderTracking = $orderTracking;
    $this->orderItem = $orderItem;
  }

  /**
   * @return JsonResponse
   */
  public function track(Request $request): JsonResponse
  {
    try {
      $order_item_id = $request->order_item_id;
      $status = strtolower($request->status);
      if ($this->orderTracking->where(['order_item_id' => $order_item_id, 'status' => $status])->exists()) {
        return $this->errorResponse('Tracking status already exists.');
      }

      $this->orderTracking->create(['order_item_id' => $order_item_id, 'status' => $status]);
      $trackings = $this->orderTracking->where(['order_item_id' => $order_item_id])->get();
      return $this->successResponse(['trackings' => $trackings]);
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  /**
   * @return JsonResponse
   */
  public function fetchAllTrackingStatus(int $order_item_id): JsonResponse
  {
    try {
      return $this->orderTracking->where(['order_item_id' => $order_item_id])->pluck('status')->toArray();
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  /**
   * @return JsonResponse
   */
  public function status(): JsonResponse
  {
    try {
      return $this->successResponse(['status' => OrderTrackingStatusEnum::array()]);
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

}
