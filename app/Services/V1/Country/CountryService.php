<?php

namespace App\Services\V1\Country;
use App\Models\City\City;
use App\Models\Country;
use App\Models\State\State;
use App\Services\BaseService;
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
            return responser()->send(Status::HTTP_OK, $countries, 'Countries fetched successfully.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, 'Unknown error. Try again.');
        }
    }

    /**
     * @return JsonResponse
     */
    public function supported(): JsonResponse
    {
        try {
            $countries = Country::isSupported()->get();
            return responser()->send(Status::HTTP_OK, $countries, 'Supported countries fetched successfully.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, 'Unknown error. Try again.');
        }
    }

    /**
     * @return JsonResponse
     */
    public function states(Request $request)
    {
        $states = State::where('country_id', $request->country_id)->get();
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
