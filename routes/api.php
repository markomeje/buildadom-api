<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\{OnboardingController};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::domain(env('STORE_URL'))->group(function() {
    Route::post('/onboarding', [OnboardingController::class, 'create']);

    Route::prefix('materials')->group(function () {
        Route::post('/all', [\App\Http\Controllers\Api\PropertiesController::class, 'all']);
    });

});
