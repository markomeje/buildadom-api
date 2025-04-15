<?php

namespace App\Services\V1\Customer\Order;
use App\Enums\Order\OrderFulfillmentStatusEnum;
use App\Enums\Order\OrderStatusEnum;
use App\Exceptions\ConfirmOrderException;
use App\Http\Resources\V1\Order\OrderFulfillmentResource;
use App\Jobs\Order\HandleMerchantFulfilledOrderConfirmedJob;
use App\Models\Order\OrderFulfillment;
use App\Notifications\V1\Order\MerchantFulfilledOrderConfirmedNotification;
use App\Services\BaseService;
use App\Traits\Order\OrderFulfillmentTrait;
use App\Utility\Status;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderFulfillmentService extends BaseService
{
    use OrderFulfillmentTrait;

    public function confirm(Request $request): JsonResponse
    {
        try {
            $fulfillment = OrderFulfillment::where(['order_id' => $request->order_id])->first();
            if (empty($fulfillment)) {
                return responser()->send(Status::HTTP_NOT_FOUND, null, 'Order fulfillment record not found.');
            }

            if ($fulfillment->is_confirmed) {
                throw new ConfirmOrderException('Order have already been confirmed.');
            }

            $order = $fulfillment->order;
            if (strtolower($order->status) !== strtolower(OrderStatusEnum::FULFILLED->value)) {
                throw new ConfirmOrderException('Only fulfilled orders can be confirmed.');
            }

            $fulfillment->update([
                'confirmation_code' => null,
                'is_confirmed' => 1,
                'confirmed_at' => Carbon::now(),
                'status' => strtolower(OrderFulfillmentStatusEnum::CONFIRMED->value),
                'payment_authorized' => 1,
            ]);

            $order->store->merchant->notify(new MerchantFulfilledOrderConfirmedNotification($order));
            HandleMerchantFulfilledOrderConfirmedJob::dispatch();

            return responser()->send(Status::HTTP_OK, new OrderFulfillmentResource($fulfillment), 'Order confirmed successfully.');
        } catch (ConfirmOrderException $c) {
            return responser()->send(Status::HTTP_NOT_ACCEPTABLE, [], $c->getMessage());
        } catch (Exception) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Order confirmation failed. Try again.');
        }
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $fulfillments = OrderFulfillment::where(['customer_id' => auth()->id()])->paginate($request->limit ?? 20);

            return responser()->send(Status::HTTP_OK, OrderFulfillmentResource::collection($fulfillments), 'Order fulfillment list fetched successfully.');
        } catch (Exception) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Fetching order fulfillment list failed. Try again.');
        }
    }
}
