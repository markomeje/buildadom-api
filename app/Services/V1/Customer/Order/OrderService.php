<?php

namespace App\Services\V1\Customer\Order;
use App\Enums\Cart\CartItemStatusEnum;
use App\Enums\Order\OrderStatusEnum;
use App\Http\Resources\V1\Customer\Order\OrderResource;
use App\Jobs\V1\Customer\Order\HandleCustomerOrderPlacementJob;
use App\Models\Cart\CartItem;
use App\Models\Order\Order;
use App\Notifications\V1\Customer\Order\CustomerOrderPlacedNotification;
use App\Services\BaseService;
use App\Traits\V1\CartItemTrait;
use App\Traits\V1\OrderTrait;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class OrderService extends BaseService
{
  use OrderTrait, CartItemTrait;

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function create(Request $request): JsonResponse
  {
    try {
      $cart_items = collect($request->cart_items)->toArray();
      $customer_id = auth()->id();

      $this->saveCartItems($cart_items, $customer_id);
      $items = CartItem::owner()->where('status', CartItemStatusEnum::PENDING->value)->get();
      foreach($items as $item) {
        $this->createOrder($item);
      }

      $orders = Order::owner()->with(['currency'])->where(['status' => OrderStatusEnum::PENDING->value])->get();
      if(empty($orders->count())) {
        throw new Exception('An error occured in placing your order.');
      }

      HandleCustomerOrderPlacementJob::dispatch($orders);
      return Responser::send(Status::HTTP_OK, OrderResource::collection($orders), 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
    }
  }

  public function list(): JsonResponse
  {
    try {
      $orders = Order::owner()->latest()->with(['currency', 'trackings'])->get();
      return Responser::send(Status::HTTP_OK, OrderResource::collection($orders), 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

  public function delete($id): JsonResponse
  {
    try {
      $order = Order::owner()->find($id);
      if(empty($order)) {
        return Responser::send(Status::HTTP_NOT_FOUND, [], 'Order not found.');
      }

      $order->delete();
      return Responser::send(Status::HTTP_OK, null, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

  /**
   * @param $id
   * @return JsonResponse
   */
  public function trackings($id): JsonResponse
  {
    try {
      $order = Order::owner()->findOrFail($id)->with(['trackings'])->first();
      return Responser::send(Status::HTTP_OK, new OrderResource($order), 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

}
