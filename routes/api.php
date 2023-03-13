<?php


header('Access-Control-Allow-Origin: '.env('FRONTEND_URL'));
header('Access-Control-Allow-Headers: origin, x-requested-with, content-type');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function() {
    Route::domain(env('ONBOARDING_URL'))->group(function() {
        Route::post('/create', [\App\Http\Controllers\V1\OnboardingController::class, 'create']);
    });

    Route::domain(env('API_URL'))->group(function() {    
        Route::post('/signup', [App\Http\Controllers\V1\SignupController::class, 'signup']);

        Route::prefix('verification')->group(function() {
            Route::post('/phone', [App\Http\Controllers\V1\VerificationController::class, 'phone']);
        });
    });

    Route::domain(env('AUTH_URL'))->group(function() {    
        Route::post('/login', [App\Http\Controllers\V1\AuthController::class, 'login']);
        Route::post('/logout', [\App\Http\Controllers\V1\AuthController::class, 'logout']);
        Route::post('/refresh', [\App\Http\Controllers\V1\AuthController::class, 'refresh']);
    });

    Route::domain(env('STORE_URL'))->group(function() {    
        Route::post('/create', [App\Http\Controllers\V1\Marchant\StoreController::class, 'create']);
    });

});











