<?php

namespace App\Http\Controllers\V1\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateShippingRequest;
use App\Services\ShippingService;
use App\Models\Shipping;
use Exception;


class ShippingController extends Controller
{
   /**
      * create Shipping details
      * @param $request, ShippingService
      */
   public function create(CreateShippingRequest $request)
   {
      try {
         if($shipping = (new ShippingService())->create($request->validated())) {
            $user = $shipping->user;
            return response()->json([
               'success' => true,
               'message' => 'Shipping created successfully',
               'shipping' => $shipping,
               'user' => ['id' => $user->id, 'name' => $user->fullname(), 'email' => $user->email, 'token' => auth()->login($user)]
            ], 201);
         }

         throw new Exception('Operation failed. Try again.');
      } catch (Exception $error) {
         return response()->json([
         'success' => false,
         'message' => $error->getMessage(),
         ], 500);
      }
   }

   /**
      * Get Marchant Shipping details
      */
   public function details()
   {
      try {
         $shipping = ShippingService::details();
         return response()->json([
         'success' => true,
         'message' => 'Shipping details retrieved successfully',
         'shipping' => $shipping,
         ], 200);
      } catch (Exception $error) {
         return response()->json([
         'success' => false,
         'message' => $error->getMessage(),
         ], 500);
      }
   }

}
