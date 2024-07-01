<?php

use App\Enums\Cart\CartItemStatusEnum;
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
    Schema::create('cart_items', function (Blueprint $table) {
      $table->id();
      $table->foreignId('customer_id')->nullable()->references('id')->on('users');
      $table->bigInteger('quantity')->default(1);
      $table->foreignId('product_id')->nullable()->references('id')->on('products');
      $table->foreignId('store_id')->nullable()->references('id')->on('stores');
      $table->string('status')->default(CartItemStatusEnum::PENDING->value);
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
    Schema::dropIfExists('cart_items');
  }
};
