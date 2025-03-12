<?php

namespace App\Services\V1\Customer\Order;
use App\Enums\Order\OrderFulfillmentStatusEnum;
use App\Enums\Order\OrderStatusEnum;
use App\Exceptions\ConfirmOrderException;
use App\Http\Resources\V1\Order\OrderFulfillmentResource;
use App\Jobs\V1\Order\HandleMerchantFulfilledOrderConfirmedJob;
use App\Models\Order\OrderFulfillment;
use App\Services\BaseService;
use App\Traits\V1\Order\OrderFulfillmentTrait;
use App\Utility\Status;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


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

            if($order_fulfillment->is_confirmed) {
                throw new ConfirmOrderException('Order have already been confirmed.', Status::HTTP_NOT_ACCEPTABLE);
            }

            if(strtolower($order_fulfillment->order->status) !== strtolower(OrderStatusEnum::FULFILLED->value)) {
                throw new ConfirmOrderException('Only fulfilled orders can be confirmed.', Status::HTTP_NOT_ACCEPTABLE);
            }

            $order_fulfillment->update([
                'confirmation_code' => null,
                'is_confirmed' => 1,
                'confirmed_at' => Carbon::now(),
                'status' => strtolower(OrderFulfillmentStatusEnum::CONFIRMED->value),
                'payment_authorized' => 1
            ]);

            HandleMerchantFulfilledOrderConfirmedJob::dispatch($order_fulfillment);
            return responser()->send(Status::HTTP_OK, new OrderFulfillmentResource($order_fulfillment), 'Order confirmed successfully.');
        } catch (ConfirmOrderException $c) {
            return responser()->send($c->getCode(), null, $c->getMessage());
        } catch (Exception $e) {
            Log::info('ORDER CONFIRMATION PAYMENT FAILED - '.$e->getMessage());
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, 'Order confirmation failed. Try again.');
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
