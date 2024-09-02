<?php

namespace App\Services\V1\Customer\Order;
use App\Http\Resources\V1\Order\OrderFulfillmentResource;
use App\Jobs\V1\Order\HandleMerchantFulfilledOrderConfirmedJob;
use App\Models\Order\OrderFulfillment;
use App\Services\BaseService;
use App\Traits\V1\Order\OrderFulfillmentTrait;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class OrderFulfillmentService extends BaseService
{
  use OrderFulfillmentTrait;

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function confirm(Request $request): JsonResponse
  {
    try {
      $order_fulfillment = OrderFulfillment::where(['order_id' => $request->order_id])->first();
      if(empty($order_fulfillment)) {
        return responser()->send(Status::HTTP_NOT_FOUND, null, 'Order fulfillment not found.');
      }

      $this->handleFulfilledOrderConfirmationChecks($order_fulfillment);

      $confirmed_fulfillment = $this->confirmFilfilledOrder($order_fulfillment);
      HandleMerchantFulfilledOrderConfirmedJob::dispatch($confirmed_fulfillment);
      return responser()->send(Status::HTTP_OK, new OrderFulfillmentResource($confirmed_fulfillment), 'Operation successful.');
    } catch (Exception $e) {
      return responser()->send($e->getCode(), null, $e->getMessage());
    }
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function list(Request $request): JsonResponse
  {
    try {
      $order_fulfillments = OrderFulfillment::where(['customer_id' => auth()->id()])->paginate($request->limit ?? 20);
      return responser()->send(Status::HTTP_OK, OrderFulfillmentResource::collection($order_fulfillments), 'Operation successful.');
    } catch (Exception $e) {
      return responser()->send($e->getCode(), null, $e->getMessage());
    }
  }

}
