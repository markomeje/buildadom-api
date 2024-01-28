<?php

namespace App\Http\Controllers\V1\Country;
use App\Utility\Responser;
use Illuminate\Http\Request;
use App\Models\Country\Country;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Country\SupportedCountry;

class SupportedCountryController extends Controller
{
  /**
   * Supported countries
   *
   * @param Request $request)
   * @return JsonResponse
   */
  public function list(Request $request)
  {
    $limit = $request->limit ?? 20;
    $countries = SupportedCountry::select(['id', 'country_id', 'status'])->with(['country' => function($query) {
          return $query->select(['id', 'flag_url', 'name', 'iso3', 'emoji']);
        }])->paginate($limit);
    return Responser::send(200, $countries, 'Supported countries fetched successfully');
  }
}
