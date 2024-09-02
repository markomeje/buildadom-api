<?php

use App\Enums\Order\OrderStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
      $table->string('tracking_number')->unique();
      $table->bigInteger('total_amount');
      $table->foreignId('product_id')->nullable()->references('id')->on('products');
      $table->bigInteger('amount');
      $table->foreignId('customer_id')->nullable()->references('id')->on('users');
      $table->bigInteger('quantity')->default(1);
      $table->foreignId('currency_id')->nullable()->references('id')->on('currencies');
      $table->foreignId('store_id')->nullable()->references('id')->on('stores');
      $table->string('status')->default(OrderStatusEnum::PENDING->value);
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
    DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
    Schema::dropIfExists('orders');
    DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
  }

};
