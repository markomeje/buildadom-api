<?php

namespace App\Services\V1\Customer\Cart;
use App\Enums\Cart\CartItemStatusEnum;
use App\Models\Cart\CartItem;
use App\Models\Product\Product;
use App\Services\BaseService;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class CartItemService extends BaseService
{
  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function add(Request $request): JsonResponse
  {
    try {
      $product_id = $request->product_id;
      $item = CartItem::owner()->where([
        'product_id' => $product_id,
        'status' => CartItemStatusEnum::PENDING->value
      ])->first();

      if(empty($item)) {
        $product = Product::find($product_id);
        $item = CartItem::create([
          'customer_id' => auth()->id(),
          'quantity' => 1,
          'product_id' => $product_id,
          'store_id' => $product->store_id,
        ]);
      }else {
        $item->update([
          'quantity' => (int)$item->quantity + 1,
        ]);
      }

      return Responser::send(Status::HTTP_OK, $item, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e->getMessage());
    }
  }

  /**
   * @return JsonResponse
   */
  public function items(Request $request): JsonResponse
  {
    try {
      $items = CartItem::owner()->where(['status' => $request->status ?? CartItemStatusEnum::PENDING->value])->get();
      return Responser::send(Status::HTTP_OK, $items, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e->getMessage());
    }
  }

}
