<?php

namespace App\Http\Controllers\V1\Marchant;
use Exception;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\V1\Orders\OrderTrackingService;
use App\Http\Requests\V1\Order\TrackOrderStatusRequest;


class OrderTrackingController extends Controller
{

  /**
   * @param OrderTrackingService $OrderTrackingService
   */
  public function __construct(public OrderTrackingService $orderTrackingService)
  {
    $this->orderTrackingService = $orderTrackingService;
  }

  /**
   *
   * @param TrackOrderStatusRequest $request
   * @return JsonResponse
   */
  public function track(TrackOrderStatusRequest $request): JsonResponse
  {
    return $this->orderTrackingService->track($request);
  }

  /**
   * @return JsonResponse
   */
  public function items(): JsonResponse
  {
    return $this->orderTrackingService->items();
  }

  /**
   * @return JsonResponse
   */
  public function status(): JsonResponse
  {
    return $this->orderTrackingService->status();
  }

}