<?php

namespace App\Services\V1\Customer\Order;
use App\Enums\Cart\CartItemStatusEnum;
use App\Enums\Order\OrderStatusEnum;
use App\Models\Cart\CartItem;
use App\Models\Order\Order;
use App\Models\User;
use App\Notifications\Customer\OrderPlacedNotification;
use App\Services\BaseService;
use App\Traits\OrderTrait;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class OrderService extends BaseService
{
  use OrderTrait;

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function create(): JsonResponse
  {
    try {
      $cart_items = CartItem::owner()->where('status', CartItemStatusEnum::PENDING->value)->get();
      if(empty($cart_items->count())) {
        return Responser::send(Status::HTTP_NOT_FOUND, null, 'No pending cart items found.');
      }

      foreach($cart_items as $item) {
        $this->createOrder($item);
      }

      $orders = Order::owner()->where(['status' => OrderStatusEnum::PENDING->value])->get();
      User::find(auth()->id())->notify(new OrderPlacedNotification());
      return Responser::send(Status::HTTP_OK, $orders, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

  public function list(): JsonResponse
  {
    try {
      $orders = Order::owner()->with([
        'currency' => function($query) {
          return $query->select(['id', 'name', 'code']);
        }
      ])->get();
      return Responser::send(Status::HTTP_OK, $orders, 'Operation successful.');
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
      return Responser::send(Status::HTTP_OK, $order, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

}
