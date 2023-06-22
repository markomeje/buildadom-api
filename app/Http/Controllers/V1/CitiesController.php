<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Exception;

class CitiesController extends Controller
{
  /**
   * Get all cities
   * @param void
   */
  public function cities()
  {
    try {
      $country_code = strtoupper(request()->get('country_code') ?? 'NG');
      $url = "https://laravel-world.com/api/states?filters[country_code]={$country_code}&fields=cities";
      $response = Http::get($url);

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
