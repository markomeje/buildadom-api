<?php

namespace App\Http\Controllers\V1\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCartRequest;
use Illuminate\Http\JsonResponse;
use App\Services\CartService;
use App\Models\Cart;
use Exception;


class CartController extends Controller
{

  /**
   * @param CartService $cart
   */
  public function __construct(public CartService $cart)
  {
    $this->cart = $cart;
  }

  /**
   * Add to cart
   *
   * @param CreateCartRequest $request
   */
  public function add(CreateCartRequest $request): JsonResponse
  {
    return $this->cart->add($request->validated());
  }

  /**
   * Get all cart items
   */
  public function items(): JsonResponse
  {
    return $this->cart->items();
  }

  /**
   * Delete from cart
   *
   * @param CreateCartRequest $request
   */
  public function delete($id): JsonResponse
  {
    return $this->cart->delete($id);
  }

}
