<?php


namespace App\Services;
use App\Models\Shipping;
use App\Models\Role;
use App\Actions\CreateUserAction;
use Illuminate\Support\Facades\DB;
use Hash;

class ShippingService
{
  /**
   * Create Shipping data
   *
   * @return JsonResonse
   * @param array
   */
  public function create(array $data)
  {
    return DB::transaction(function() use($data) {
      if(auth()->user()) {
        $user = auth()->user();
        $token = auth()->refresh();
      }else {
        $user = CreateUserAction::handle(['email' => $data['email'], 'phone' => $data['phone'], 'type' => 'individual', 'password' => Hash::make(str()->random(4)), 'status' => 'active', 'firstname' => $data['firstname'], 'lastname' => $data['lastname']]);
        Role::create(['name' => 'customer', 'user_id' => $user->id]);
        $token = auth()->login($user);
      }

      $details = ['street_address' => $data['street_address'], 'city' => $data['city'], 'state' => $data['state'], 'country_id' => $data['country_id'], 'zip_code' => $data['zip_code'], 'shipping_fee' => 2400];
      $shipping = Shipping::create([
        'status' => 'pending',
        'user_id' => $user->id,
        ...$details,
      ]);

      return response()->json([
        'success' => true,
        'message' => 'Operation successful',
        'shipping' => $shipping,
        'token' => $token,
      ], 201);
    });
  }

  /**
   * Shipping details
   */
  public static function details()
  {
    return Shipping::where(['user_id' => auth()->id()])->get();
  }
}












