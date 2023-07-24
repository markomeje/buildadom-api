<?php


namespace App\Services\V1\Orders;
use Exception;
use App\Models\Product;
use App\Models\V1\Cart;
use App\Services\BaseService;
use App\Models\V1\Orders\Order;
use Illuminate\Http\JsonResponse;
use App\Models\V1\Orders\OrderItem;
use App\Enums\V1\Order\OrderStatusEnum;


class OrderItemService extends BaseService
{

  /**
   * @param Order $order
   */
  public function __construct(public Order $order, Cart $cart, public OrderItem $orderItem)
  {
    $this->orderItem = $orderItem;
  }

  /**
   * Fetch save order
   *
   * @return Order
   * @param array
   */
  public function save(array $data)
  {
    try {
      $items = $this->orderItem->updateOrCreate(
        ['product_id' => $data['product_id'], 'user_id' => auth()->id()], 
        [...$data]
      );
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  /**
   * @return JsonResponse
   */
  public function items(): JsonResponse
  {
    try {
      $user = auth()->user();
      if (empty($user->store)) {
        return $this->errorResponse('Invalid store details');
      }

      $store = $user->store;
      $orders = $this->orderItem->with(['product' => function($product) {
        return $product->with(['images']);
      }])->where(['store_id' => $store->id])->get();
      
      return $this->successResponse(['orders' => $orders]);
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

}












