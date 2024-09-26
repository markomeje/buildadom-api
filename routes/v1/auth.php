<?php

use App\Http\Controllers\V1\Auth\LoginController;
use App\Http\Controllers\V1\Auth\PasswordResetController;
use App\Http\Controllers\V1\Bank\BankAccountController;
use App\Http\Controllers\V1\Document\DocumentTypeController;
use App\Http\Controllers\V1\Email\EmailVerificationController;
use App\Http\Controllers\V1\Kyc\KycFileController;
use App\Http\Controllers\V1\Kyc\KycVerificationController;
use App\Http\Controllers\V1\Phone\PhoneVerificationController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::prefix('/password')->group(function() {
  Route::post('/reset', [PasswordResetController::class, 'reset']);
  Route::post('/initiate-reset', [PasswordResetController::class, 'initiate']);
  Route::post('/confirm-reset-code', [PasswordResetController::class, 'confirm']);
});

Route::middleware(['auth:api'])->group(function() {
  Route::prefix('/phone')->group(function() {
    Route::post('/verify', [PhoneVerificationController::class, 'verify']);
    Route::post('/resend-code', [PhoneVerificationController::class, 'resend']);
  });

  Route::get('/document-types', [DocumentTypeController::class, 'list']);

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

  Route::prefix('bank')->group(function() {
    Route::get('/details', [BankAccountController::class, 'details']);
    Route::post('/save-account', [BankAccountController::class, 'save']);
  });
});
