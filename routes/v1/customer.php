<?php

use App\Http\Controllers\V1\Customer\Auth\CustomerSignupController;
use App\Http\Controllers\V1\Customer\Cart\CartItemController;
use Illuminate\Support\Facades\Route;




Route::prefix('cart')->group(function() {
  Route::post('/add-item', [CartItemController::class, 'add']);
  Route::get('/items', [CartItemController::class, 'items']);
});

Route::prefix('auth')->group(function() {
  Route::post('/signup', [CustomerSignupController::class, 'signup']);
});