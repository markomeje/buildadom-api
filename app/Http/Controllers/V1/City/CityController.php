<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\City;
use App\Http\Controllers\Controller;
use App\Models\City\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Get all countries
     *
     * @return JsonResponse
     */
    public function list(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Cities retrieved successfully',
            'countries' => City::paginate($request->limit ?? 20),
        ], 200);
    }
}
