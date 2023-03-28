<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('orders', function (Blueprint $table) {
      $table->id();
      $table->string('number');
      $table->string('status')->default('pending');
      $table->float('total');
      $table->integer('quantity');
      $table->boolean('paid')->default(false);
      $table->enum('payment_method', ['cash_on_delivery'])->default('cash_on_delivery');

      $table->string('notes')->nullable();
      $table->foreignId('user_id')->nullable()->references('id')->on('users');
      //$table->foreignId('product_id')->nullable()->references('id')->on('products');
      $table->foreignId('store_id')->nullable()->references('id')->on('stores');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('orders');
  }

};
