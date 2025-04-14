<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Merchant\Auth\MerchantSignupController;
use App\Http\Controllers\V1\Merchant\Driver\DispatchDriverController;
use App\Http\Controllers\V1\Merchant\Order\OrderController;
use App\Http\Controllers\V1\Merchant\Order\OrderSettlementController;
use App\Http\Controllers\V1\Merchant\Order\OrderTrackingController;
use App\Http\Controllers\V1\Merchant\Payment\PaymentController;
use App\Http\Controllers\V1\Merchant\Product\ProductController;
use App\Http\Controllers\V1\Merchant\Product\ProductImageController;
use App\Http\Controllers\V1\Merchant\Store\StoreController;
use App\Http\Controllers\V1\Merchant\Store\StoreUploadController;
use Illuminate\Support\Facades\Route;

Route::post('signup', [MerchantSignupController::class, 'signup']);
Route::middleware(['auth:api', 'merchants.only', 'merchants.kyc.verified'])->group(function ()
{

    Route::prefix('store')->group(function ()
    {
        Route::post('create', [StoreController::class, 'create']);
        Route::post('{id}/update', [StoreController::class, 'update']);
        Route::get('list', [StoreController::class, 'list']);
        Route::post('{id}/publish', [StoreController::class, 'publish']);

        Route::post('{store_id}/upload-logo', [StoreUploadController::class, 'logo']);
        Route::post('{store_id}/upload-banner', [StoreUploadController::class, 'banner']);
    });

    Route::prefix('product')->group(function ()
    {
        Route::get('list', [ProductController::class, 'list']);
        Route::post('add', [ProductController::class, 'add']);

        Route::post('{id}/update', [ProductController::class, 'update']);
        Route::get('{id}/details', [ProductController::class, 'product']);
        Route::post('{id}/publish', [ProductController::class, 'publish']);

        Route::prefix('image')->group(function ()
        {
            Route::post('upload', [ProductImageController::class, 'upload']);
            Route::post('{id}/delete', [ProductImageController::class, 'delete']);
            Route::post('{id}/change', [ProductImageController::class, 'change']);
        });
    });

    Route::prefix('driver')->group(function ()
    {
        Route::get('list', [DispatchDriverController::class, 'list']);
        Route::post('add', [DispatchDriverController::class, 'add']);
        Route::post('update', [DispatchDriverController::class, 'update']);
    });

    Route::prefix('order')->group(function ()
    {
        Route::get('list', [OrderController::class, 'list']);
        Route::post('track', [OrderTrackingController::class, 'track']);
        Route::post('{id}/action', [OrderController::class, 'action']);

        Route::prefix('settlement')->group(function ()
        {
            Route::get('list', [OrderSettlementController::class, 'list']);
        });
    });

    Route::prefix('payment')->group(function ()
    {
        Route::get('list', [PaymentController::class, 'list']);
    });
});
