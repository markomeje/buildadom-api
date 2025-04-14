<?php

declare(strict_types=1);

namespace App\Services\V1\Cart;
use App\Enums\CartStatusEnum;
use App\Models\V1\Cart;
use App\Models\V1\Orders\Order;
use App\Services\BaseService;
use App\Services\V1\Orders\OrderService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartService extends BaseService
{
    public function __construct(public Cart $cart, public OrderService $orderService, public Order $order)
    {
        $this->cart = $cart;
        $this->order = $order;
        $this->orderService = $orderService;
    }

    public function add(Request $request): JsonResponse
    {
        try {
            $product_id = $request->product_id;
            $cart = $this->cart->where(['user_id' => auth()->id(), 'product_id' => $product_id])->first();
            if (empty($cart)) {
                $quantity = $request->quantity ?? 1;
                $cart = $this->cart->create(['quantity' => $quantity, 'status' => CartStatusEnum::ACTIVE->value, 'product_id' => $product_id, 'user_id' => auth()->id()]);
            } else {
                $quantity = $cart->quantity + 1;
                $cart->update(['quantity' => $quantity, 'status' => CartStatusEnum::ACTIVE->value]);
            }

            return $this->successResponse(['cart' => $cart]);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage() . ' on Line ' . $e->getLine());
        }
    }

    public function items(): JsonResponse
    {
        try {
            $items = $this->cart->with(['product' => function ($query)
            {
                return $query->with(['images', 'unit']);
            }])->latest()->where(['user_id' => auth()->id(), 'status' => CartStatusEnum::ACTIVE->value])->get();

            return $this->successResponse(['items' => $items]);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $deleted = $this->cart->findOrFail($id)->delete();

            return $this->successResponse(['deleted' => $deleted]);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
