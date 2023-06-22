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
    $shipping = Shipping::create([
      'status' => 'pending',
      'shipping_fee' => rand(2400, 9700),
      'user_id' => auth()->id(),
      ...$data,
    ]);

    return response()->json([
      'success' => true,
      'message' => 'Operation successful',
      'shipping' => $shipping,
    ], 201);
  }

  /**
   * Shipping details
   */
  public static function details()
  {
    return Shipping::where(['user_id' => auth()->id()])->get();
  }
}












