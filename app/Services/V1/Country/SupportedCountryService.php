<?php

namespace App\Services\V1\Country;
use App\Models\Country\SupportedCountry;
use App\Services\BaseService;
use App\Utility\Responser;
use App\Utility\Status;
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
      $countries = SupportedCountry::all();
      if(!$countries->count()) {
        return Responser::send(Status::HTTP_OK, [], 'No supported countries listed.');
      }

      $countries = collect($countries)->map(function($supported) {
        $country = $supported->country;
        return collect([
          'id' => $supported->id,
          'phone_code' => $country->phone_code,
          'country_id' => $country->id,
          'name' => $country->name,
          'iso3' => $country->iso3,
          'emoji' => $country->emoji,
          'iso2' => $country->iso2,
          'flag_url' => $country->flag_url,
        ]);
      });

      return Responser::send(Status::HTTP_OK, $countries, 'Supported countries fetched successfully.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Unknown error. Try again.');
    }
  }
}