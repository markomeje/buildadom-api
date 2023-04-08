<?php


namespace App\Services;
use App\Models\Shipping;
use App\Actions\CreateUserAction;
use Illuminate\Support\Facades\DB;

class ShippingService
{
  /**
   * Create Shipping data
   *
   * @return Shipping
   * @param array
   */
   public function create(array $data): Shipping
   {
      return DB::transaction(function() use($data) {
         $user = CreateUserAction::handle(['email' => $data['email'], 'phone' => $data['phone'], 'type' => $data['type'], 'address' => $data['address'], 'password' => $data['password'], 'status' => 'active']);

         $details = ['street_address' => $data['street_address'], 'city' => $data['city'], 'state' => $data['state'], 'country_id' => $data['country_id'], 'zip_code' => $data['zip_code']];
         return Shipping::create([
         'status' => 'pending',
         'user_id' => $user->id,
         ...$details,
         ]);
      });
   }

  /**
   * Shipping details
   */
   public static function details()
   {
      return Shipping::where(['user_id' => auth()->id()])->first();
   }
}












