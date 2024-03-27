<?php

namespace App\Services\V1\Customer\Cart;
use App\Models\Cart\CartItem;
use App\Services\BaseService;
use App\Traits\CartTrait;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class CartItemService extends BaseService
{
  use CartTrait;

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function add(Request $request): JsonResponse
  {
    // try {
      $cart = $this->createCart();
      $cart_id = $cart->id;
      $product_id = $request->product_id;

      $item = CartItem::owner()->where([
        'cart_id' => $cart_id,
        'product_id' => $product_id,
      ])->first();

      if(empty($item)) {
        $item = CartItem::create([
          'user_id' => auth()->id(),
          'cart_id' => $cart_id,
          'quantity' => 1,
          'product_id' => $product_id,
        ]);
      }else {
        $item->update([
          'quantity' => $item->quantity + 1,
        ]);
      }

      return Responser::send(Status::HTTP_OK, $item, 'Operation successful.');
    // } catch (Exception $e) {
    //   return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e->getMessage());
    // }
  }

  /**
   * @return JsonResponse
   */
  public function items(): JsonResponse
  {
    try {
      $items = CartItem::owner()->get();
      return Responser::send(Status::HTTP_OK, $items, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e->getMessage());
    }
  }

}
