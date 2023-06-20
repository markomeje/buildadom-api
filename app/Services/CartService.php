<?php


namespace App\Services;
use App\Enums\CartStatusEnum;
use App\Enums\OrderStatusEnum;
use Illuminate\Http\JsonResponse;
use App\Models\Product;
use App\Models\Cart;
use Exception;

/**
 * Service class
 */
class CartService
{

  /**
   * @param CartService $cart
   */
  public function __construct(public Cart $cart, public OrderService $orderService, public Product $product)
  {
    $this->cart = $cart;
    $this->orderService = $orderService;
    $this->product = $product;
  }

  /**
   * Add to cart Record
   *
   * @return JsonResponse
   * @param array $data
   *
   */
  public function add(array $data): JsonResponse
  {
    try {
      $product = $this->product->findOrFail($data['product_id']);
      $order = $this->orderService->save($product->price);
      $cart = $this->cart->create([
        ...$data,
        'order_id' => $order->id,
        'status' => CartStatusEnum::ACTIVE->value,
        'user_id' => auth()->id(),
      ]);

      return response()->json([
        'success' => true,
        'cart' => $cart,
        'message' => 'Operation successful'
      ]);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage()
      ], 500);
    }
  }

  /**
   * Get all cart items
   *
   * @return JsonResponse
   *
   */
  public function items(): JsonResponse
  {
    try {
      $items = $this->cart->with(['product' => function($query) {
        return  $query->with(['images']);
      }])->latest()->where(['user_id' => auth()->id()])->get();

      return response()->json([
        'success' => true,
        'items' => $items,
        'message' => 'Operation successful'
      ]);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage()
      ], 500);
    }
  }

  /**
   * Delete cart item
   *
   * @return JsonResponse
   *
   */
  public function delete(int $id): JsonResponse
  {
    try {
      $deleted = $this->cart->findOrFail($id)->delete();
      return response()->json([
        'success' => $deleted,
        'message' => 'Operation successful'
      ]);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage()
      ], 500);
    }
  }

}












