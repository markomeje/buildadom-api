<?php

$origin = request()->headers->get('origin');
$origin = app()->environment(['production']) ? (in_array($origin, ['http://localhost:3000', env('FRONTEND_URL'), 'http://localhost:6100', 'https://buildadom-admin.netlify.app']) ? $origin : '') : '*';

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
      Route::post('/signup', [\App\Http\Controllers\V1\SignupController::class, 'marchant']);
      Route::post('/verification/verify', [App\Http\Controllers\V1\VerificationController::class, 'verify']);
      Route::post('/verification/code/resend', [App\Http\Controllers\V1\VerificationController::class, 'resend']);

      Route::post('/login', [\App\Http\Controllers\V1\AuthController::class, 'login']);

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

        Route::middleware(['auth:api'])->prefix('cart')->group(function() {
          Route::any('/add', [App\Http\Controllers\V1\Customer\CartController::class, 'add']);
          Route::get('/items', [App\Http\Controllers\V1\Customer\CartController::class, 'items']);
        });

        Route::prefix('google')->group(function() {
          Route::post('/auth', [App\Http\Controllers\V1\GoogleController::class, 'login']);
          Route::post('/callback', [App\Http\Controllers\V1\GoogleController::class, 'callback']);
        });

        Route::prefix('shipping')->group(function() {
          Route::post('/create', [App\Http\Controllers\V1\Customer\ShippingController::class, 'create']);
          Route::post('/signup', [\App\Http\Controllers\V1\SignupController::class, 'customer']);
        });
      });

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

      Route::prefix('reset')->group(function() {
         Route::post('/process', [App\Http\Controllers\V1\ResetController::class, 'process']);
         Route::post('/update', [App\Http\Controllers\V1\ResetController::class, 'update']);
      });

      Route::middleware(['auth:api'])->group(function() {
         Route::prefix('auth')->group(function() {
            Route::post('/user', [\App\Http\Controllers\V1\UserController::class, 'user']);
            Route::post('/logout', [\App\Http\Controllers\V1\AuthController::class, 'logout']);
            Route::post('/refresh', [\App\Http\Controllers\V1\AuthController::class, 'refresh']);
         });

         Route::prefix('marchant')->group(function() {

            Route::prefix('store')->group(function() {
              Route::post('/create', [\App\Http\Controllers\V1\Marchant\StoreController::class, 'create']);
              Route::post('/update/{id}', [\App\Http\Controllers\V1\Marchant\StoreController::class, 'update']);
              Route::get('/', [\App\Http\Controllers\V1\Marchant\StoreController::class, 'store']);

              Route::post('/publish/{id}', [\App\Http\Controllers\V1\Marchant\StoreController::class, 'publish']);
            });

            Route::get('/drivers', [\App\Http\Controllers\V1\Marchant\DriverController::class, 'drivers']);

            Route::prefix('driver')->group(function() {
               Route::post('/add', [\App\Http\Controllers\V1\Marchant\DriverController::class, 'add']);
               Route::post('/update/{id}', [\App\Http\Controllers\V1\Marchant\DriverController::class, 'update']);
               Route::get('/{id}', [\App\Http\Controllers\V1\Marchant\DriverController::class, 'store']);
               Route::delete('/delete/{id}', [\App\Http\Controllers\V1\Marchant\DriverController::class, 'delete']);
            });

            Route::prefix('image')->group(function() {
               Route::post('/upload', [\App\Http\Controllers\V1\ImageController::class, 'upload']);
            });

            Route::get('/products', [\App\Http\Controllers\V1\Marchant\ProductController::class, 'products']);

            Route::prefix('product')->group(function() {
               Route::post('/create', [\App\Http\Controllers\V1\Marchant\ProductController::class, 'create']);
               Route::post('/update/{id}', [\App\Http\Controllers\V1\Marchant\ProductController::class, 'update']);
               Route::get('/{id}', [\App\Http\Controllers\V1\Marchant\ProductController::class, 'product']);

               Route::post('/publish/{id}', [\App\Http\Controllers\V1\Marchant\ProductController::class, 'publish']);
            });

            Route::prefix('identification')->group(function() {
               Route::post('/save', [\App\Http\Controllers\V1\Marchant\IdentificationController::class, 'save']);

               Route::get('/details', [\App\Http\Controllers\V1\Marchant\IdentificationController::class, 'details']);
            });

            Route::prefix('account')->group(function() {
               Route::post('/save', [\App\Http\Controllers\V1\Marchant\AccountController::class, 'save']);

               Route::get('/information', [\App\Http\Controllers\V1\Marchant\AccountController::class, 'information']);
            });
         });
      });
   });
});











