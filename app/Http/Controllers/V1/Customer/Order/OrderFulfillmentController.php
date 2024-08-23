<?php

namespace App\Http\Controllers\V1\Customer\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Customer\Order\ConfirmOrderFulfillmentRequest;
use App\Services\V1\Customer\Order\OrderFulfillmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class OrderFulfillmentController extends Controller
{
  /**
   * @param OrderFulfillmentService $orderFulfillmentService
   */
  public function __construct(public OrderFulfillmentService $orderFulfillmentService)
  {
    $this->orderFulfillmentService = $orderFulfillmentService;
  }

  /**
   * @param ConfirmOrderFulfillmentRequest $request
   * @return JsonResponse
   */
  public function confirm(ConfirmOrderFulfillmentRequest $request): JsonResponse
  {
    return $this->orderFulfillmentService->confirm($request);
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function list(Request $request): JsonResponse
  {
    return $this->orderFulfillmentService->list($request);
  }

}
