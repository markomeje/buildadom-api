<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('escrow_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->nullable()->references('id')->on('payments');
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->decimal('amount', 18, 2);
            $table->string('payment_type');
            $table->foreignId('escrow_account_id')->nullable()->references('id')->on('escrow_accounts');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('escrow_payments');
    }
};
