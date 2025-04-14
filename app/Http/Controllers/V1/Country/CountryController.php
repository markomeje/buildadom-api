<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Country;
use App\Http\Controllers\Controller;
use App\Models\City\City;
use App\Models\State\State;
use App\Services\V1\Country\CountryService;
use App\Utility\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct(private CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function list(): JsonResponse
    {
        return $this->countryService->list();
    }

    public function supported(): JsonResponse
    {
        return $this->countryService->supported();
    }

    /**
     * @return JsonResponse
     */
    public function states(Request $request)
    {
        $country_id = $request->country_id ?? 0;
        $states = State::where('country_id', $country_id)->get();

        return responser()->send(Status::HTTP_OK, $states, 'States fetched successfully');
    }

    /**
     * @return JsonResponse
     */
    public function cities(Request $request)
    {
        $query = City::query();
        if ($request->state_id) {
            $query->where('state_id', $request->state_id);
        }

        $cities = $query->where('country_id', $request->country_id)->get();

        return responser()->send(Status::HTTP_OK, $cities, 'Cities fetched successfully');
    }
}
