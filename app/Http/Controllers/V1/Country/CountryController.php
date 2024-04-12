<?php

namespace App\Http\Controllers\V1\Country;
use App\Http\Controllers\Controller;
use App\Models\City\City;
use App\Models\State\State;
use App\Services\V1\Country\CountryService;
use App\Utility\Responser;
use App\Utility\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends Controller
{
  /**
   * @param CountryService $countryService
   */
  public function __construct(private CountryService $countryService)
  {
    $this->countryService = $countryService;
  }

  /**
   * @return JsonResponse
   */
  public function list(): JsonResponse
  {
    return $this->countryService->list();
  }

  /**
   * @return JsonResponse
   */
  public function supported(): JsonResponse
  {
    return $this->countryService->supported();
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
