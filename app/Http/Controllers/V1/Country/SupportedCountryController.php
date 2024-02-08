<?php

namespace App\Http\Controllers\V1\Country;
use App\Http\Controllers\Controller;
use App\Services\V1\Country\SupportedCountryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupportedCountryController extends Controller
{

  public function __construct(private SupportedCountryService $supportedCountry)
  {
    $this->supportedCountry = $supportedCountry;
  }
  /**
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function list(Request $request): JsonResponse
  {
    return $this->supportedCountry->list($request);
  }
}
