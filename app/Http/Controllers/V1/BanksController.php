<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class BanksController extends Controller
{
  /**
   * get Logged in user
   * @param $request
   */
  public function banks()
  {
    try {
      $response = Http::get('https://nigerianbanks.xyz');
      if ($response->failed()) {
        return $response->throw();
      }

      return $response->json();
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage()
      ], 500);
    }
  }
}
