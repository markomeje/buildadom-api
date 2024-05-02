<?php

use App\Http\Controllers\V1\Customer\Auth\CustomerSignupController;
use App\Http\Controllers\V1\Customer\Cart\CartItemController;
use App\Http\Controllers\V1\Customer\Escrow\EscrowAccountController;
use App\Http\Controllers\V1\Customer\Order\OrderController;
use App\Http\Controllers\V1\Customer\Payment\PaymentController;
use Illuminate\Support\Facades\Route;

Route::post('/signup', [CustomerSignupController::class, 'signup']);

Route::middleware(['auth:api'])->group(function() {
  Route::prefix('cart')->group(function() {
    Route::post('/add', [CartItemController::class, 'add']);
    Route::get('/items', [CartItemController::class, 'items']);
  });

  Route::prefix('order')->group(function() {
    Route::post('/create', [OrderController::class, 'create']);
    Route::get('/list', [OrderController::class, 'list']);
  });

  Route::prefix('payment')->group(function() {
    Route::post('/initialize', [PaymentController::class, 'initialize']);
    Route::get('/list', [PaymentController::class, 'list']);
  });

  Route::prefix('escrow')->group(function() {
    Route::get('/accounts', [EscrowAccountController::class, 'accounts']);
  });

});