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
  Route::middleware(['auth:api'])->prefix('user')->group(function() {
    Route::get('/me', [UserController::class, 'me']);
  });

  Route::post('/signup', [SignupController::class, 'marchant']);

  Route::post('/verification/verify', [App\Http\Controllers\V1\VerificationController::class, 'verify']);
  Route::post('/verification/code/resend', [App\Http\Controllers\V1\VerificationController::class, 'resend']);

  Route::post('/login', [AuthController::class, 'login']);

  Route::prefix('stores')->group(function() {
    Route::get('/', [App\Http\Controllers\V1\StoresController::class, 'index']);
    Route::get('/store/{id}', [App\Http\Controllers\V1\StoresController::class, 'store']);
  });

  Route::prefix('admin')->group(function() {
    Route::prefix('identifications')->group(function() {
      Route::get('/', [\App\Http\Controllers\V1\Admin\IdentificationController::class, 'index']);
      Route::get('/identification/{id}', [\App\Http\Controllers\V1\Admin\IdentificationController::class, 'identification']);

      Route::post('/verify/{id}', [\App\Http\Controllers\V1\Admin\IdentificationController::class, 'verify']);
    });
  });

  Route::prefix('customer')->group(function() {
    Route::post('/signup', [App\Http\Controllers\V1\SignupController::class, 'customer']);
    Route::prefix('shipping')->group(function() {
      Route::post('/create', [App\Http\Controllers\V1\Customer\ShippingController::class, 'create']);
      Route::get('/details', [App\Http\Controllers\V1\Customer\ShippingController::class, 'details'])->middleware(['auth:api']);
    });

    Route::middleware(['auth:api'])->group(function() {
      Route::prefix('cart')->group(function() {
        Route::post('/add', [CartController::class, 'add']);
        Route::get('/items', [CartController::class, 'items']);
        Route::delete('/delete/{id}', [CartController::class, 'delete']);
      });

      Route::prefix('order')->group(function() {
        Route::post('/save', [OrderController::class, 'save']);
        Route::get('/details/{id}', [OrderController::class, 'details']);
        Route::get('/all', [OrderController::class, 'orders']);
      });

      Route::prefix('payment')->group(function() {
        Route::post('/initialize', [App\Http\Controllers\V1\Customer\PaymentController::class, 'initialize']);
        Route::post('/verify', [App\Http\Controllers\V1\Customer\PaymentController::class, 'verify']);
        Route::post('/webhook', [App\Http\Controllers\V1\Customer\PaymentController::class, 'webhook']);
      });
    });
  });

  Route::get('/order/status', [OrderTrackingController::class, 'status']);
  Route::get('/units', [UnitController::class, 'units']);

  Route::prefix('products')->group(function() {
    Route::get('/', [App\Http\Controllers\V1\ProductsController::class, 'index']);
    Route::get('/categories', [App\Http\Controllers\V1\ProductsController::class, 'categories']);
    Route::get('/product/{id}', [App\Http\Controllers\V1\ProductsController::class, 'product']);

    Route::get('/category/{id}', [App\Http\Controllers\V1\ProductsController::class, 'category']);
  });

  Route::get('/categories/products', [App\Http\Controllers\V1\CategoryController::class, 'products']);

  Route::get('/countries', [App\Http\Controllers\V1\CountriesController::class, 'countries']);
  Route::get('/cities', [App\Http\Controllers\V1\CitiesController::class, 'cities']);
  Route::get('/banks', [App\Http\Controllers\V1\BanksController::class, 'banks']);
  Route::get('/identification/types', [\App\Http\Controllers\V1\Marchant\IdentificationController::class, 'types']);
  Route::get('/currencies', [App\Http\Controllers\V1\CurrencyController::class, 'index']);
