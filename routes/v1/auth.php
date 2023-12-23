<?php

use App\Http\Controllers\V1\Verification\EmailVerificationController;
use App\Http\Controllers\V1\Verification\PhoneVerificationController;



Route::middleware(['auth'])->group(function() {

  Route::prefix('/phone')->group(function() {
    Route::post('/verify', [PhoneVerificationController::class, 'verify']);
    Route::post('/resend-code', [PhoneVerificationController::class, 'resend']);
  });

  Route::prefix('email')->group(function() {
    Route::post('/verify', [EmailVerificationController::class, 'verify']);
    Route::post('/resend-code', [EmailVerificationController::class, 'resend']);
  });

});
