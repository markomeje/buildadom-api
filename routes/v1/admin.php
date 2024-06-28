<?php

use App\Http\Controllers\V1\Admin\Kyc\KycVerificationController;
use App\Http\Controllers\V1\Admin\Merchant\MerchantController;
use Illuminate\Support\Facades\Route;


Route::middleware([])->group(function() {
  Route::prefix('kyc')->group(function() {
    Route::post('/action/{id}', [KycVerificationController::class, 'action']);
    Route::get('/list', [KycVerificationController::class, 'list']);
  });

  Route::prefix('merchant')->group(function() {
    Route::get('/list', [MerchantController::class, 'list']);
  });
});