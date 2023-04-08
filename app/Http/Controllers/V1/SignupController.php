<?php

namespace App\Http\Controllers\V1;
use App\Http\Requests\{MarchantSignupRequest, CustomerSignupRequest};
use App\Services\{MarchantSignupService, CustomerSignupService};
use App\Http\Controllers\Controller;
use Exception;


class SignupController extends Controller
{
  /**
   * Signup marchant user
   * @param $request
   */
   public function marchant(MarchantSignupRequest $request)
   {
      try {
         (new MarchantSignupService())->signup($request->validated());
         return response()->json([
         'success' => true,
         'message' => 'Signup successful. A verification code have been sent to your phone.',
         ], 201);
      } catch (Exception $error) {
         return response()->json([
         'success' => false,
         'message' => $error->getMessage(),
         ], 500);
      }
            
   }

   /**
   * Signup customer user
   * @param $request $signup
   */
   public function customer(CustomerSignupRequest $request)
   {
      try {
         (new CustomerSignupService())->signup($request->validated());
         return response()->json([
         'success' => true,
         'message' => 'Signup successfull.',
         ], 201);
      } catch (Exception $error) {
         return response()->json([
         'success' => false,
         'message' => $error->getMessage(),
         ], 500);
      }
            
   }
}
