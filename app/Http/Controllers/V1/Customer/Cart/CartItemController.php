<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Customer\Cart;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Customer\Cart\CreateCartItemRequest;
use App\Services\V1\Customer\Cart\CartItemService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function __construct(public CartItemService $cartItemService)
    {
        $this->cartItemService = $cartItemService;
    }

    public function add(CreateCartItemRequest $request): JsonResponse
    {
        return $this->cartItemService->add($request);
    }

    public function items(Request $request): JsonResponse
    {
        return $this->cartItemService->items($request);
    }
}
