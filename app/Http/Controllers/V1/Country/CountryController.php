<?php

namespace App\Http\Controllers\V1\Country;
use App\Http\Controllers\Controller;
use App\Models\City\City;
use App\Models\Country\Country;
use App\Models\State\State;
use App\Utility\Responser;
use App\Utility\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends Controller
{
  /**
   * Get all countries
   * @param Request $request)
   * @return JsonResponse
   */
  public function countries(Request $request)
  {
    $query = Country::query();
    if(isset($request->iso2))  {
      $query->where('iso2', $request->iso2);
    }

    $countries = $query->get();
    return Responser::send(Status::HTTP_OK, $countries, 'Countries retrieved successfully');
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function states(Request $request)
  {
    $country_id = $request->country_id ?? 0;
    $states = State::where('country_id', $country_id)->get();
    return Responser::send(Status::HTTP_OK, $states, 'Country states fetched successfully');
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function cities(Request $request)
  {
    $country_id = $request->country_id ?? 0;
    $cities = City::where('country_id', $country_id)->get();
    return Responser::send(Status::HTTP_OK, $cities, 'Country cities fetched successfully');
  }

}
