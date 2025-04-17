<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: origin, x-requested-with, content-type');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');

use App\Http\Controllers\V1\Bank\NigerianBankController;
use App\Http\Controllers\V1\Country\CountryController;
use App\Http\Controllers\V1\Currency\CurrencyController;
use App\Http\Controllers\V1\Fee\FeeSettingController;
use App\Http\Controllers\V1\Logistics\LogisticsCompanyController;
use App\Http\Controllers\V1\Payment\PaystackWebhookController;
use App\Http\Controllers\V1\Product\ProductCategoryController;
use App\Http\Controllers\V1\Product\ProductController;
use App\Http\Controllers\V1\Product\ProductUnitController;
use App\Http\Controllers\V1\Store\StoreController;
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

Route::middleware([])->domain(config('app.api_url'))->prefix('v1')->group(function () {
    Route::middleware(['accept.json'])->group(function () {

        Route::prefix('admin')->name('admin.')->group(base_path('routes/v1/admin.php'));
        Route::prefix('merchant')->name('merchant.')->group(base_path('routes/v1/merchant.php'));
        Route::prefix('customer')->name('customer.')->group(base_path('routes/v1/customer.php'));
        Route::prefix('auth')->name('auth.')->group(base_path('routes/v1/auth.php'));

        Route::prefix('country')->group(function () {
            Route::get('list', [CountryController::class, 'list']);
            Route::get('supported-countries', [CountryController::class, 'supported']);
            Route::get('states', [CountryController::class, 'states']);
            Route::get('cities', [CountryController::class, 'cities']);
        });

        Route::prefix('currency')->group(function () {
            Route::get('list', [CurrencyController::class, 'list']);
        });

        Route::prefix('banks')->group(function () {
            Route::get('list', [NigerianBankController::class, 'list']);
        });

        Route::prefix('fees')->group(function () {
            Route::get('show', [FeeSettingController::class, 'show']);
        });

        Route::prefix('product')->group(function () {
            Route::get('list', [ProductController::class, 'list']);
            Route::get('show/{id}', [ProductController::class, 'show']);
            Route::get('search', [ProductController::class, 'search']);
            Route::get('filter', [ProductController::class, 'filter']);

            Route::prefix('category')->group(function () {
                Route::get('list', [ProductCategoryController::class, 'list']);
            });

            Route::prefix('unit')->group(function () {
                Route::get('list', [ProductUnitController::class, 'list']);
            });
        });

        Route::prefix('store')->group(function () {
            Route::get('list', [StoreController::class, 'list']);
            Route::get('search', [StoreController::class, 'search']);
            Route::get('show/{slug}', [StoreController::class, 'show']);
        });

        Route::prefix('logistics')->group(function () {
            Route::prefix('company')->group(function () {
                Route::post('create', [LogisticsCompanyController::class, 'create']);
                Route::post('update', [LogisticsCompanyController::class, 'update']);
                Route::get('list', [LogisticsCompanyController::class, 'list']);
            });
        });
    });

    Route::any('webhook', [PaystackWebhookController::class, 'webhook']);
});
