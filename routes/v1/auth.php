<?php

use App\Http\Controllers\V1\Auth\LoginController;
use App\Http\Controllers\V1\Email\EmailVerificationController;
use App\Http\Controllers\V1\Kyc\KycVerificationController;
use App\Http\Controllers\V1\Phone\PhoneVerificationController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [LoginController::class, 'login']);
Route::middleware(['auth'])->group(function() {
  Route::prefix('/phone')->group(function() {
    Route::post('/verify', [PhoneVerificationController::class, 'verify']);
    Route::post('/resend/code', [PhoneVerificationController::class, 'resend']);
  });

  Route::prefix('email')->group(function() {
    Route::post('/verify', [EmailVerificationController::class, 'verify']);
    Route::post('/resend-code', [EmailVerificationController::class, 'resend']);
  });

  Route::prefix('kyc')->group(function() {
    Route::post('/initialize', [KycVerificationController::class, 'initialize']);
    Route::post('/info', [KycVerificationController::class, 'info']);

    Route::prefix('document')->group(function() {
      Route::post('/upload/{id}', [KycVerificationController::class, 'upload']);
      Route::post('/list', [KycVerificationController::class, 'list']);
    });
  });
});