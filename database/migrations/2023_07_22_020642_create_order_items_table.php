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
    Schema::create('order_items', function (Blueprint $table) {
      $table->id();
      $table->foreignId('product_id')->nullable()->references('id')->on('products');
      $table->decimal('amount', 28, 2);
      $table->foreignId('user_id')->nullable()->references('id')->on('users');
      $table->bigInteger('quantity')->nullable();
      $table->foreignId('store_id')->nullable()->references('id')->on('stores');
      $table->foreignId('order_id')->nullable()->references('id')->on('orders');
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
    Schema::dropIfExists('order_items');
  }
};
