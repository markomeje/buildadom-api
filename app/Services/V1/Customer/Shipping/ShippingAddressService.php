<?php

namespace App\Services\V1\Customer\Shipping;
use App\Models\Shipping\ShippingAddress;
use App\Services\BaseService;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShippingAddressService extends BaseService
{
    public function update(Request $request): JsonResponse
    {
        try {
            $user_id = auth()->id();
            $address = $request->street_address;
            $shipping = ShippingAddress::updateOrCreate(['user_id' => $user_id], [
                'user_id' => $user_id,
                'street_address' => $address,
                'city_id' => $request->city_id,
                'state_id' => $request->state_id,
                'country_id' => help()->getDefaultCountry()->id,
                'zip_code' => $request->zip_code,
            ]);

            $shipping->user->update(['address' => $address]);

            return responser()->send(Status::HTTP_OK, $shipping, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
        }
    }

    public function details(): JsonResponse
    {
        try {
            $address = ShippingAddress::owner()->first();

            return responser()->send(Status::HTTP_OK, $address, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
        }
    }
}
