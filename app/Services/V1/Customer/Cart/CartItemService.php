<?php

namespace App\Services\V1\Customer\Cart;
use App\Models\Cart\CartItem;
use App\Services\BaseService;
use App\Traits\CartItemTrait;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartItemService extends BaseService
{
    use CartItemTrait;

    public function add(Request $request): JsonResponse
    {
        try {
            $item = $this->saveCartItem($request, auth()->id());

            return responser()->send(Status::HTTP_OK, $item, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
        }
    }

    public function items(Request $request): JsonResponse
    {
        try {
            $query = CartItem::query()->owner();
            if ($request->get('status')) {
                $query->where('status', $request->status);
            }

            $items = $query->paginate($request->limit ?? 20);

            return responser()->send(Status::HTTP_OK, $items, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
        }
    }
}
