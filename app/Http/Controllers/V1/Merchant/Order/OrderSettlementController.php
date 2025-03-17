<?php

namespace App\Http\Controllers\V1\Merchant\Order;
use App\Http\Controllers\Controller;
use App\Services\V1\Merchant\Order\OrderSettlementService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class OrderSettlementController extends Controller
{
    /**
     * @param OrderSettlementService $orderSettlementService
     */
    public function __construct(public OrderSettlementService $orderSettlementService)
    {
        $this->orderSettlementService = $orderSettlementService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        return $this->orderSettlementService->list($request);
    }

}
