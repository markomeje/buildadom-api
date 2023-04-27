<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Http\Resources\CurrencyResource;
use App\Models\Currency;

class CurrencyController extends Controller
{
  /**
   * Get all Currencies
   * @param json
   */
  public function index()
  {
    return response()->json([
      'success' => true,
      'message' => 'Currencies retrieved successfully',
      'currencies' => CurrencyResource::collection(Currency::all())
    ], 200);
  }
}
