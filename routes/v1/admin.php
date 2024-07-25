<?php

use App\Http\Controllers\V1\Admin\Fee\FeeSettingController;
use App\Http\Controllers\V1\Admin\Kyc\KycVerificationController;
use App\Http\Controllers\V1\Admin\Merchant\MerchantController;
use App\Http\Controllers\V1\Admin\Order\OrderController;
use App\Http\Controllers\V1\Admin\Payment\PaymentController;
use Illuminate\Support\Facades\Route;






Route::middleware([])->group(function() {
  Route::prefix('kyc')->group(function() {
    Route::post('/action/{id}', [KycVerificationController::class, 'action']);
    Route::get('/list', [KycVerificationController::class, 'list']);
  });

  Route::prefix('merchant')->group(function() {
    Route::get('/list', [MerchantController::class, 'list']);
  });

  Route::prefix('order')->group(function() {
    Route::get('/list', [OrderController::class, 'list']);
  });

  Route::prefix('fees')->group(function() {
    Route::get('/list', [FeeSettingController::class, 'list']);
  });

  Route::prefix('payment')->group(function() {
    Route::get('/list', [PaymentController::class, 'list']);
  });
});