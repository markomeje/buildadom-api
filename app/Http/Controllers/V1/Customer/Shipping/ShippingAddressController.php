<?php

namespace App\Http\Controllers\V1\Customer\Shipping;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Customer\Shipping\UpdateShippingAddressRequest;
use App\Services\V1\Customer\Shipping\ShippingAddressService;
use Illuminate\Http\JsonResponse;

class ShippingAddressController extends Controller
{
    public function __construct(private ShippingAddressService $shippingAddressService)
    {
        $this->shippingAddressService = $shippingAddressService;
    }

    public function update(UpdateShippingAddressRequest $request): JsonResponse
    {
        return $this->shippingAddressService->update($request);
    }

    public function details(): JsonResponse
    {
        return $this->shippingAddressService->details();
    }
}
