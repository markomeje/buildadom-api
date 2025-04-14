<?php

declare(strict_types=1);

namespace App\Services\V1\Country;
use App\Models\Country;
use App\Services\BaseService;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;

class CountryService extends BaseService
{
    public function list(): JsonResponse
    {
        try {
            $countries = Country::all();

            return responser()->send(Status::HTTP_OK, $countries, 'Countries fetched successfully.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Unknown error. Try again.');
        }
    }

    /**
     * Supported countries
     */
    public function supported(): JsonResponse
    {
        try {
            $countries = Country::isSupported()->get();

            return responser()->send(Status::HTTP_OK, $countries, 'Supported countries fetched successfully.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Unknown error. Try again.');
        }
    }
}
