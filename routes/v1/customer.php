<?php

use App\Http\Controllers\V1\Customer\Auth\CustomerSignupController;
use App\Http\Controllers\V1\Customer\Cart\CartItemController;
use App\Http\Controllers\V1\Customer\Escrow\EscrowAccountController;
use App\Http\Controllers\V1\Customer\Order\OrderController;
use App\Http\Controllers\V1\Customer\Order\OrderDeliveryController;
use App\Http\Controllers\V1\Customer\Order\OrderPaymentController;
use App\Http\Controllers\V1\Customer\Payment\PaymentController;
use App\Http\Controllers\V1\Customer\Shipping\ShippingAddressController;
use Illuminate\Support\Facades\Route;





Route::post('/signup', [CustomerSignupController::class, 'signup']);

Route::middleware(['auth:api', 'customers.only'])->group(function() {
  Route::prefix('cart')->group(function() {
    Route::post('/add', [CartItemController::class, 'add']);
    Route::get('/items', [CartItemController::class, 'items']);
  });

  Route::prefix('order')->group(function() {
    Route::post('/create', [OrderController::class, 'create']);
    Route::get('/list', [OrderController::class, 'list']);
    Route::get('/payment', [OrderPaymentController::class, 'list']);
    Route::get('/{id}/trackings', [OrderController::class, 'trackings']);
    Route::post('/{id}/cancel', [OrderController::class, 'cancel']);
    Route::post('/{id}/delete', [OrderController::class, 'delete']);

    Route::prefix('payment')->group(function() {
      Route::get('/list', [OrderPaymentController::class, 'list']);
      Route::post('/initialize', [OrderPaymentController::class, 'initialize']);
    });

    Route::prefix('delivery')->group(function() {
      Route::post('/confirm', [OrderDeliveryController::class, 'confirm']);
    });
  });

  Route::prefix('payment')->group(function() {
    Route::post('/initialize', [PaymentController::class, 'initialize']);
    Route::get('/list', [PaymentController::class, 'list']);
  });

  Route::prefix('escrow')->group(function() {
    Route::get('/account', [EscrowAccountController::class, 'details']);
  });

  Route::prefix('shipping')->group(function() {
    Route::prefix('address')->group(function() {
      Route::post('/update', [ShippingAddressController::class, 'update']);
      Route::post('/details', [ShippingAddressController::class, 'details']);
    });
  });

});