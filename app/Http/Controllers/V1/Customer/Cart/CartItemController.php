<?php

namespace App\Http\Controllers\V1\Customer\Cart;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Customer\Cart\CreateCartItemRequest;
use App\Services\V1\Customer\Cart\CartItemService;
use Illuminate\Http\JsonResponse;


class CartItemController extends Controller
{

  /**
   * @param CartItemService $cartItemService
   */
  public function __construct(public CartItemService $cartItemService)
  {
    $this->cartItemService = $cartItemService;
  }

  /**
   * Add to cart
   *
   * @param CreateCartItemRequest $request
   */
  public function add(CreateCartItemRequest $request): JsonResponse
  {
    return $this->cartItemService->add($request);
  }

  /**
   * @return JsonResponse
   */
  public function items(): JsonResponse
  {
    return $this->cartItemService->items();
  }

}
