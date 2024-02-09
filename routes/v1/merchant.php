<?php

use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\Customer\Orders\OrderItemController;
use App\Http\Controllers\V1\ImageController;
use App\Http\Controllers\V1\Merchant\Auth\MerchantSignupController;
use App\Http\Controllers\V1\Merchant\StoreController;
use App\Http\Controllers\V1\OrderTrackingController;
use Illuminate\Support\Facades\Route;




Route::middleware(['merchant'])->group(function() {
  Route::prefix('store')->group(function() {
    Route::post('/create', [StoreController::class, 'create']);
    Route::post('/update/{id}', [StoreController::class, 'update']);
    Route::get('/', [StoreController::class, 'store']);
    Route::post('/publish/{id}', [StoreController::class, 'publish']);
  });
});

// Route::middleware(['auth:api'])->group(function() {
//   Route::prefix('auth')->group(function() {
//     Route::post('/user', [UserController::class, 'user']);
//     Route::post('/logout', [AuthController::class, 'logout']);
//     Route::post('/refresh', [AuthController::class, 'refresh']);
//   });

//   Route::prefix('order')->group(function() {
//     Route::post('/track', [OrderTrackingController::class, 'track']);
//     Route::get('/items', [OrderItemController::class, 'items']);
//   });

//   Route::prefix('store')->group(function() {
//     Route::post('/create', [StoreController::class, 'create']);
//     Route::post('/update/{id}', [StoreController::class, 'update']);
//     Route::get('/', [StoreController::class, 'store']);
//     Route::post('/publish/{id}', [StoreController::class, 'publish']);
//   });

//   Route::prefix('driver')->group(function() {
//     Route::get('/list', [DriverController::class, 'drivers']);
//     Route::post('/add', [DriverController::class, 'add']);
//     Route::post('/update/{id}', [DriverController::class, 'update']);
//     Route::get('/{id}', [DriverController::class, 'store']);
//     Route::delete('/delete/{id}', [DriverController::class, 'delete']);
//   });

//   Route::prefix('image')->group(function() {
//     Route::post('/upload', [ImageController::class, 'upload']);
//   });

//   Route::get('/products', [ProductController::class, 'products']);

//   Route::prefix('product')->group(function() {
//     Route::post('/create', [ProductController::class, 'create']);
//     Route::post('/update/{id}', [ProductController::class, 'update']);
//     Route::get('/{id}', [ProductController::class, 'product']);

//     Route::post('/publish/{id}', [ProductController::class, 'publish']);
//   });

//   Route::prefix('identification')->group(function() {
//     Route::post('/save', [IdentificationController::class, 'save']);

//     Route::get('/details', [IdentificationController::class, 'details']);
//   });

//   Route::prefix('account')->group(function() {
//     Route::post('/save', [AccountController::class, 'save']);

//     Route::get('/information', [AccountController::class, 'information']);
//   });
// });
