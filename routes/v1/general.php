<?php

use App\Http\Controllers\V1\Country\CountryController;
use App\Http\Controllers\V1\Country\SupportedCountryController;
use App\Http\Controllers\V1\Customer\Auth\CustomerSignupController;
use App\Http\Controllers\V1\Merchant\Auth\MerchantSignupController;
use Illuminate\Support\Facades\Route;



Route::prefix('country')->group(function() {
  Route::get('/list', [CountryController::class, 'list']);
  Route::get('/supported-countries', [CountryController::class, 'supported']);
  Route::get('/states', [CountryController::class, 'states']);
  Route::get('/cities', [CountryController::class, 'cities']);
});
