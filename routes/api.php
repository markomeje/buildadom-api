<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: origin, x-requested-with, content-type');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\Country\CountryController;
use App\Http\Controllers\V1\Customer\Cart\CartController;
use App\Http\Controllers\V1\Customer\Orders\OrderController;
use App\Http\Controllers\V1\Marchant\OrderTrackingController;
use App\Http\Controllers\V1\Merchant\Auth\MerchantSignupController;
use App\Http\Controllers\V1\SignupController;
use App\Http\Controllers\V1\UnitController;
use App\Http\Controllers\V1\UserController;
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
Route::middleware(['accept.json'])->domain(env('API_URL'))->prefix('v1')->group(function() {
  Route::prefix('/admin')->name('admin.')->group(base_path('routes/v1/admin.php'));
  Route::middleware(['auth:api'])->prefix('/merchant')->name('merchant.')->group(base_path('routes/v1/merchant.php'));
  Route::middleware(['auth:api'])->prefix('/customer')->name('customer.')->group(base_path('routes/v1/customer.php'));
  Route::prefix('/auth')->name('auth.')->group(base_path('routes/v1/auth.php'));

  Route::prefix('country')->group(function() {
    Route::get('/list', [CountryController::class, 'list']);
    Route::get('/supported-countries', [CountryController::class, 'supported']);
    Route::get('/states', [CountryController::class, 'states']);
    Route::get('/cities', [CountryController::class, 'cities']);
  });

  Route::post('/merchant/signup', [MerchantSignupController::class, 'signup']);
});
