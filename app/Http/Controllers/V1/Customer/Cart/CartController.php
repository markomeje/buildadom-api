<?php

namespace App\Http\Controllers\V1\Customer\Cart;
use Exception;
use App\Models\Cart;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\V1\Cart\CartService;
use App\Http\Requests\V1\Cart\CreateCartRequest;


class CartController extends Controller
{

  /**
   * @param CartService $cartService
   */
  public function __construct(public CartService $cartService)
  {
    $this->cartService = $cartService;
  }

  /**
   * Add to cart
   *
   * @param CreateCartRequest $request
   */
  public function add(CreateCartRequest $request): JsonResponse
  {
    return $this->cartService->add($request);
  }

  /**
   * @return JsonResponse
   */
  public function items(): JsonResponse
  {
    return $this->cartService->items();
  }

  /**
   * @return JsonResponse
   * @param int $id
   */
  public function delete(int $id): JsonResponse
  {
    return $this->cartService->delete($id);
  }

}
