<?php

namespace App\Http\Controllers\V1\Country;
use App\Http\Controllers\Controller;
use App\Services\V1\Country\CountryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * @param  \App\Services\V1\Country\CountryService  $countryService
     */
    public function __construct(private CountryService $countryService) {}

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
     * @return JsonResponse
     */
    public function states(Request $request)
    {
        return $this->countryService->states($request);
    }

    /**
     * @return JsonResponse
     */
    public function cities(Request $request)
    {
        return $this->countryService->cities($request);
    }
}
