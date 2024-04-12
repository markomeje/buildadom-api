<?php

namespace App\Services\V1\Country;
use App\Models\Country;
use App\Services\BaseService;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class CountryService extends BaseService
{
  /**
   * @return JsonResponse
   */
  public function list(): JsonResponse
  {
    try {
      $countries = Country::all();
      return Responser::send(Status::HTTP_OK, $countries, 'Countries fetched successfully.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Unknown error. Try again.');
    }
  }

  /**
   * Supported countries
   * @return JsonResponse
   */
  public function supported(): JsonResponse
  {
    try {
      $countries = Country::isSupported()->get();
      return Responser::send(Status::HTTP_OK, $countries, 'Supported countries fetched successfully.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Unknown error. Try again.');
    }
  }

}