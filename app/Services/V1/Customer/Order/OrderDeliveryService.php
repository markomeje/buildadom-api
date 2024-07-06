<?php

namespace App\Services\V1\Customer\Order;
use App\Http\Resources\V1\Order\OrderDeliveryResource;
use App\Jobs\V1\Order\HandleMerchantDeliveredOrderConfirmedJob;
use App\Models\Order\OrderDelivery;
use App\Services\BaseService;
use App\Traits\V1\Order\OrderDeliveryTrait;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class OrderDeliveryService extends BaseService
{
  use OrderDeliveryTrait;

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function confirm(Request $request): JsonResponse
  {
    try {
      $order_delivery = OrderDelivery::where(['order_id' => $request->order_id])->first();
      $this->handleDeliveredOrderConfirmationChecks($order_delivery);

      $confirmed_delivery = $this->confirmDeliveredOrder($order_delivery);
      HandleMerchantDeliveredOrderConfirmedJob::dispatch($confirmed_delivery);
      return Responser::send(Status::HTTP_OK, new OrderDeliveryResource($confirmed_delivery), 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send($e->getCode(), null, $e->getMessage());
    }
  }

}
