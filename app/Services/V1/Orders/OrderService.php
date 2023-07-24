<?php


namespace App\Services\V1\Orders;
use Exception;
use App\Models\Product;
use App\Models\V1\Cart;
use App\Enums\CartStatusEnum;
use App\Services\BaseService;
use App\Models\V1\Orders\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Enums\V1\Order\OrderStatusEnum;
use App\Services\V1\Orders\OrderItemService;


class OrderService extends BaseService
{

  /**
   * @param Order $order
   */
  public function __construct(public Order $order, Cart $cart, public OrderItemService $orderItemService, public Product $product)
  {
    $this->order = $order;
    $this->cart = $cart;
    $this->orderItemService = $orderItemService;
    $this->product = $product;
  }

  /**
   * @return JsonResponse
   */
  public function save(): JsonResponse
  {
    try {
      $items = $this->cart->where(['user_id' => auth()->id(), 'status' => CartStatusEnum::ACTIVE->value])->get();
      if (empty($items->count())) {
        return $this->errorResponse('No active cart items.');
      }

      DB::transaction(function () use($items) {
        collect($items->toArray())->each(function ($cart) {
          $this->saveLatestOrderDetails($this->product->findOrFail($cart['product_id']), $cart['quantity']);
        });

        $this->cart->where(['user_id' => auth()->id()])->update(['status' => CartStatusEnum::FULFILLED->value]);
      });

      return $this->successResponse(['order' => $this->fetchLatestPendingOrder()]);
    } catch (Exception $e) {
      return $this->errorResponse("{$e->getMessage()} on line {$e->getLine()}");
    }
  }

  /**
   * @return null | Order
   */
  public function fetchLatestPendingOrder(): ?Order
  {
    try {
      return $this->order->latest()->where(['user_id' => auth()->id(), 'status' => OrderStatusEnum::PENDING->value])->first();
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  /**
   * Generate random unique 11 digit code
   *
   * @return string
   */
  public function generateUniqueTrackingNumber(): string
  {
    do {
      $number = strtoupper(str()->random(15));
    } while ($this->order->where(['tracking_number' => $number])->first());
    return $number;
  }

  /**
   * @return Order
   */
  public function saveLatestOrderDetails(Product $product, int $quantity): Order
  {
    try {
      $product_price = $product->price;
      $order = $this->fetchLatestPendingOrder();
      if(empty($order)) {
        $order = $this->order->create(['tracking_number' => $this->generateUniqueTrackingNumber(), 'total_amount' => $product_price, 'user_id' => auth()->id()]);
      }else {
        $updated_price = $order->total_amount + $product_price;
        $order->update(['total_amount' => $updated_price]);
      }

      $this->orderItemService->save(['product_id' => $product->id, 'store_id' => $product->store->id, 'order_id' => $order->id, 'quantity' => $quantity, 'user_id' => auth()->id(), 'amount' => $product_price]);
      return $order;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  /**
   * @return JsonResponse
   * @param int $id
   */
  public function details(int $id): JsonResponse
  {
    try {
      $order = $this->order->where(['id' => $id, 'user_id' => auth()->id()])->first();
      return $this->successResponse(['order' => $order]);
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  /**
   * @return JsonResponse
   */
  public function orders(): JsonResponse
  {
    try {
      $orders = $this->order->where(['user_id' => auth()->id()])->get();
      return $this->successResponse(['orders' => $orders]);
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}












