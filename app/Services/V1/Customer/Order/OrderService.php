<?php

namespace App\Services\V1\Customer\Order;
use App\Enums\Cart\CartItemStatusEnum;
use App\Enums\Order\OrderStatusEnum;
use App\Http\Resources\V1\Order\OrderResource;
use App\Models\Cart\CartItem;
use App\Models\Order\Order;
use App\Notifications\V1\Order\CustomerOrderStatusUpdateNotification;
use App\Services\BaseService;
use App\Traits\CartItemTrait;
use App\Traits\OrderTrait;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderService extends BaseService
{
    use CartItemTrait;
    use OrderTrait;

    public function create(Request $request): JsonResponse
    {
        try {
            $cart_items = collect($request->cart_items)->toArray();
            $customer_id = auth()->id();

            foreach ($cart_items as $item) {
                $this->saveCartItem((object) $item, $customer_id);
            }

            $items = CartItem::owner()->where('status', CartItemStatusEnum::PENDING->value)->get();
            foreach ($items as $item) {
                $this->createOrder($item);
            }

            $orders = Order::owner()->isPending()->get();

            return responser()->send(Status::HTTP_OK, OrderResource::collection($orders), 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
        }
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $query = Order::query()->owner()->latest();
            if (!empty($request->status)) {
                $query->where('status', $request->status);
            }

            $orders = $query->with(['currency', 'trackings', 'fulfillment', 'product' => function ($query) {
                $query->with(['images', 'category', 'unit', 'currency']);
            }, 'store'])->paginate($request->limit ?? 0);

            return responser()->send(Status::HTTP_OK, OrderResource::collection($orders), 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            $order = Order::owner()->find($id);
            if (empty($order)) {
                return responser()->send(Status::HTTP_NOT_FOUND, null, 'Order not found.');
            }

            if (strtolower($order->status) !== strtolower(OrderStatusEnum::PENDING->value)) {
                return responser()->send(Status::HTTP_NOT_ACCEPTABLE, null, 'Only pending orders can be deleted.');
            }

            $deleted = $order->delete();

            return responser()->send(Status::HTTP_OK, ['deleted' => $deleted], 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
        }
    }

    /**
     * @param  int  $id
     */
    public function trackings($id): JsonResponse
    {
        try {
            $order = Order::owner()->with(['trackings', 'currency', 'store', 'product' => function ($query) {
                $query->with(['images', 'category', 'unit', 'currency']);
            }, 'fulfillment'])->find($id);

            if (empty($order)) {
                return responser()->send(Status::HTTP_NOT_FOUND, null, 'Order not found.');
            }

            return responser()->send(Status::HTTP_OK, new OrderResource($order), 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
        }
    }

    public function cancel($id): JsonResponse
    {
        try {
            $order = Order::owner()->find($id);
            if (empty($order)) {
                return responser()->send(Status::HTTP_NOT_FOUND, null, 'Order not found.');
            }

            if (strtolower($order->status) !== strtolower(OrderStatusEnum::PENDING->value)) {
                return responser()->send(Status::HTTP_NOT_ACCEPTABLE, null, 'Only pending orders can be cancelled.');
            }

            $order->update(['status' => strtolower(OrderStatusEnum::CANCELLED->value)]);
            $order->customer->notify(new CustomerOrderStatusUpdateNotification($order));

            return responser()->send(Status::HTTP_OK, null, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
        }
    }
}
