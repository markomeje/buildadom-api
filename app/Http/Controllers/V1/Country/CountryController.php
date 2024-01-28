<?php

namespace App\Http\Controllers\V1\Country;
use App\Utility\Responser;
use Illuminate\Http\Request;
use App\Models\Country\Country;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
  /**
   * Get all countries
   * @param Request $request)
   * @return JsonResponse
   */
  public function list(Request $request)
  {
    $query = Country::query();
    if(isset($request->iso2))  {
      $query->where('iso2', $request->iso2);
    }

    $limit = $request->limit ?? 20;
    $countries = $query->with(['states' => function($query) {
        return $query->with(['cities'])->select(['id', 'country_id', 'name']);
      }])->paginate($request->limit ?? 20);

    return Responser::send(200, $countries, 'Countries retrieved successfully');
  }
}
