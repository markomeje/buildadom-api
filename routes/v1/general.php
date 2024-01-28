<?php

use App\Http\Controllers\V1\City\CityController;
use App\Http\Controllers\V1\Country\CountryController;
use App\Http\Controllers\V1\Country\SupportedCountryController;



Route::prefix('country')->group(function() {
  Route::get('/list', [CountryController::class, 'list']);
});

Route::prefix('city')->group(function() {
  Route::get('/list', [CityController::class, 'list']);
});

Route::get('/supported-countries', [SupportedCountryController::class, 'list']);
