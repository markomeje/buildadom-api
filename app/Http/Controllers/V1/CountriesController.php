<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Models\Country;

class CountriesController extends Controller
{
  /**
   * Get all countries
   * @param json
   */
  public function countries()
  {
    return response()->json([
      'success' => true,
      'message' => 'Countries retrieved successfully',
      'countries' => CountryResource::collection(Country::all())
    ], 200);
  }
}
