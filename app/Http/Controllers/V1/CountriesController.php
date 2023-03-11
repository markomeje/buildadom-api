<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Models\Country;

class CountriesController extends Controller
{
    /**
     * Get all countries
     * @param void
     */
    public function all()
    {
        return response()->json([
            'success' => true,
            'message' => 'Countries returned',
            'countries' => Country::all()
        ], 201);
    }
}
