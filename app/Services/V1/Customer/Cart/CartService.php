<?php

namespace App\Services\V1\Customer\Cart;
use App\Services\BaseService;
use App\Traits\CartTrait;
use App\Utility\Responser;
use App\Utility\Status;
use App\Utility\Uploader;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class CartService extends BaseService
{
  use CartTrait;

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function create(): JsonResponse
  {
    try {
      // $cart = $this->isPendingCart();
      // if(empty($cart)) {
      //   $cart = Cart::create([
      //     'status' => CartStatusEnum::PENDING->value,
      //     'user_id' => auth()->id(),
      //   ]);
      // }

      return Responser::send(Status::HTTP_OK, [], 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e->getMessage());
    }
  }

}
