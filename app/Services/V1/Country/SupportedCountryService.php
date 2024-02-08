<?php

namespace App\Services\V1\Country;
use App\Models\Country\SupportedCountry;
use App\Services\BaseService;
use App\Utility\Responser;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class SupportedCountryService extends BaseService
{
  /**
   * Supported countries
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function list(Request $request): JsonResponse
  {
    try {
      $countryQuery = function($query) {
        $query->select(['id', 'flag_url', 'name', 'iso3', 'emoji']);
      };

      $countries = SupportedCountry::select(['id', 'country_id'])->with(['country' => $countryQuery])->get();
      return Responser::send(JsonResponse::HTTP_OK, $countries, 'Supported countries fetched successfully.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], 'Unknown error. Try again.');
    }
  }
}