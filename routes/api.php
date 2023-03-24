<?php


header("Access-Control-Allow-Origin: *");
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

Route::middleware(['accept.json'])->prefix('v1')->group(function() {

  Route::domain(env('ONBOARDING_URL'))->group(function() {
    Route::post('/create', [\App\Http\Controllers\V1\OnboardingController::class, 'create']);
  });

  Route::domain(env('API_URL'))->group(function() {    
    Route::post('/signup', [App\Http\Controllers\V1\SignupController::class, 'signup']);
    Route::post('/verification/verify', [App\Http\Controllers\V1\VerificationController::class, 'verify']);

    Route::prefix('stores')->group(function() {
      Route::post('/', [App\Http\Controllers\V1\StoreController::class, 'index']);
      Route::post('/store/{id}', [App\Http\Controllers\V1\StoreController::class, 'store']);
    });

    Route::prefix('auth')->group(function() {
      Route::post('/login', [App\Http\Controllers\V1\AuthController::class, 'login']);
      Route::post('/logout', [\App\Http\Controllers\V1\AuthController::class, 'logout']);
      Route::post('/refresh', [\App\Http\Controllers\V1\AuthController::class, 'refresh']);
    });

    Route::post('/countries', [App\Http\Controllers\V1\CountriesController::class, 'countries']);

    Route::prefix('user')->group(function() {
      Route::post('/me', [App\Http\Controllers\V1\UserController::class, 'me']);
    });

    Route::prefix('reset')->group(function() {
      Route::post('/process', [App\Http\Controllers\V1\ResetController::class, 'process']);
      Route::post('/update', [App\Http\Controllers\V1\ResetController::class, 'update']);
    });

    Route::middleware(['auth:api'])->group(function() {
      Route::prefix('store')->group(function() {
        Route::post('/{id}', [App\Http\Controllers\V1\Marchant\StoreController::class, 'store']);
        Route::post('/create', [App\Http\Controllers\V1\Marchant\StoreController::class, 'create']);
        Route::post('/update/{id}', [App\Http\Controllers\V1\Marchant\StoreController::class, 'update']);
      });

      Route::prefix('image')->group(function() {
        Route::post('/upload', [App\Http\Controllers\V1\ImageController::class, 'upload']);
      });
    });

  });

});











