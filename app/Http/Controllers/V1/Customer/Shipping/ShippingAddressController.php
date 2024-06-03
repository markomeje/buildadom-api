<?php

namespace App\Http\Controllers\V1\Customer\Shipping;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Customer\Shipping\UpdateShippingAddressRequest;
use App\Services\V1\Customer\Shipping\ShippingAddressService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ShippingAddressController extends Controller
{
  /**
   * @param ShippingAddressService $shippingAddressService
   */
  public function __construct(private ShippingAddressService $shippingAddressService)
  {
    $this->shippingAddressService = $shippingAddressService;
  }

  /**
   * @param UpdateShippingAddressRequest $request
   * @return JsonResponse
   */
  public function update(UpdateShippingAddressRequest $request): JsonResponse
  {
    return $this->shippingAddressService->update($request);
  }

  /**
   * @return JsonResponse
   */
  public function details(): JsonResponse
  {
    return $this->shippingAddressService->details();
  }

}
