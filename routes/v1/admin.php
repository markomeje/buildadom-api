<?php

use App\Http\Controllers\V1\Admin\Kyc\KycVerificationController;
use Illuminate\Support\Facades\Route;

Route::middleware([])->group(function() {
  Route::prefix('kyc')->group(function() {
    Route::post('/action/{id}', [KycVerificationController::class, 'action']);
  });
});