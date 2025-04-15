<?php

use App\Enums\Order\OrderPaymentStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->references('id')->on('orders');
            $table->foreignId('payment_id')->nullable()->references('id')->on('payments');
            $table->foreignId('customer_id')->nullable()->references('id')->on('users');
            $table->string('status')->default(OrderPaymentStatusEnum::PENDING->value);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_payments');
    }
};
