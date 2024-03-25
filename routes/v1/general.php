<?php

use App\Http\Controllers\V1\City\CityController;
use App\Http\Controllers\V1\Country\CountryController;
use App\Http\Controllers\V1\Country\SupportedCountryController;
use Illuminate\Support\Facades\Route;




Route::prefix('country')->group(function() {
  Route::get('/list', [CountryController::class, 'countries']);
  Route::get('/states', [CountryController::class, 'states']);
  Route::get('/cities', [CountryController::class, 'cities']);
});

Route::get('/supported-countries', [SupportedCountryController::class, 'list']);
