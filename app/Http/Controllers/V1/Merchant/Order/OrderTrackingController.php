<?php

namespace App\Http\Controllers\V1\Merchant\Order;
use App\Http\Controllers\Controller;
use App\Services\V1\Merchant\Order\OrderTrackingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


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
     * @param Request $request
     * @return JsonResponse
     */
    public function track(Request $request): JsonResponse
    {
        return $this->orderTrackingService->track($request);
    }

}
