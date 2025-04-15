<?php

use App\Enums\Order\OrderSettlementStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('order_settlements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->references('id')->on('orders');
            $table->foreignId('merchant_id')->nullable()->references('id')->on('users');
            $table->foreignId('payment_id')->nullable()->references('id')->on('payments');
            $table->string('type')->nullable();
            $table->string('description')->nullable();
            $table->string('status')->default(OrderSettlementStatusEnum::PENDING->value);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_settlements');
    }
};
