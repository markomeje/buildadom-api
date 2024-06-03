<?php

namespace App\Services\V1\Customer\Shipping;
use App\Models\Shipping\ShippingAddress;
use App\Services\BaseService;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ShippingAddressService extends BaseService
{
  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function update(Request $request): JsonResponse
  {
    try {
      $user_id = auth()->id();
      $shipping = ShippingAddress::updateOrCreate(['user_id' => $user_id], [
        'user_id' => $user_id,
        'street_address' => $request->street_address,
        'city_id' => $request->city_id,
        'state_id' => $request->state_id,
        'country_id' => defaultCountry()->id,
        'zip_code' => $request->zip_code,
      ]);

      return Responser::send(Status::HTTP_OK, $shipping, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
    }
  }

  /**
   * @return JsonResponse
   */
  public function details(): JsonResponse
  {
    try {
      $address = ShippingAddress::owner()->first();
      return Responser::send(Status::HTTP_OK, $address, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

}
