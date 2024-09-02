<?php

namespace App\Http\Controllers\V1\City;
use App\Models\City\City;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class CityController extends Controller
{

  /**
   * Get all countries
   * @param Request $request)
   * @return JsonResponse
   */
  public function list(Request $request)
  {
    return response()->json([
      'success' => true,
      'message' => 'Cities retrieved successfully',
      'countries' => City::paginate($request->limit ?? 20)
    ], 200);
  }
}
