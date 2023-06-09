<?php


namespace App\Services;
use App\Enums\CartStatusEnum;
use Illuminate\Http\JsonResponse;
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
  public function __construct(public Cart $cart)
  {
    $this->cart = $cart;
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
      $cart = $this->cart->updateOrCreate(['product_id' => $data['product_id']], [
        ...$data,
        'status' => CartStatusEnum::ACTIVE->value,
        'user_id' => auth()->id()
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
      $items = $this->cart->latest()->where(['user_id' => auth()->id()])->get();
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

}












