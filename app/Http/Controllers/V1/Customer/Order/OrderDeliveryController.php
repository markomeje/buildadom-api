<?php

namespace App\Http\Controllers\V1\Customer\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Customer\Order\ConfirmOrderDeliveryRequest;
use App\Services\V1\Customer\Order\OrderDeliveryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class OrderDeliveryController extends Controller
{
  /**
   * @param OrderDeliveryService $orderService
   */
  public function __construct(public OrderDeliveryService $orderDeliveryService)
  {
    $this->orderDeliveryService = $orderDeliveryService;
  }

  /**
   * @param $id
   * @param ConfirmOrderDeliveryRequest $request
   * @return JsonResponse
   */
  public function confirm(ConfirmOrderDeliveryRequest $request): JsonResponse
  {
    return $this->orderDeliveryService->confirm($request);
  }

}
