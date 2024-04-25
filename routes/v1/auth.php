<?php

use App\Http\Controllers\V1\Auth\LoginController;
use App\Http\Controllers\V1\Email\EmailVerificationController;
use App\Http\Controllers\V1\Kyc\KycFileController;
use App\Http\Controllers\V1\Kyc\KycVerificationController;
use App\Http\Controllers\V1\Phone\PhoneVerificationController;
use App\Http\Controllers\V1\Upload\UploadController;
use Illuminate\Support\Facades\Route;




Route::post('/login', [LoginController::class, 'login']);
Route::middleware(['auth'])->group(function() {
  Route::prefix('/phone')->group(function() {
    Route::post('/verify', [PhoneVerificationController::class, 'verify']);
    Route::post('/resend-code', [PhoneVerificationController::class, 'resend']);
  });

  Route::prefix('email')->group(function() {
    Route::post('/verify', [EmailVerificationController::class, 'verify']);
    Route::post('/resend-code', [EmailVerificationController::class, 'resend']);
  });

  Route::prefix('kyc')->group(function() {
    Route::prefix('verification')->group(function() {
      Route::post('/initialize', [KycVerificationController::class, 'initialize']);
      Route::get('/info', [KycVerificationController::class, 'info']);
    });

    Route::prefix('file')->group(function() {
      Route::post('/upload', [KycFileController::class, 'upload']);
      Route::post('/change/{id}', [KycFileController::class, 'change']);
      Route::get('/list', [KycFileController::class, 'list']);
      Route::post('/delete/{id}', [KycFileController::class, 'delete']);
    });
  });

  Route::prefix('upload')->group(function() {
    Route::post('/handle/{id?}', [UploadController::class, 'handle']);
    Route::post('/delete/{id}', [UploadController::class, 'delete']);
  });
});
