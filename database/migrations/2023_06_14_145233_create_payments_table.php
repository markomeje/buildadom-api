<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Enums\PaymentStatusEnum;
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
    Schema::create('payments', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->nullable()->references('id')->on('users');
      $table->boolean('paid')->default(PaymentStatusEnum::NOT_PAID->value);
      $table->bigInteger('amount');
      $table->foreignId('order_id')->nullable()->references('id')->on('orders');
      $table->string('type')->nullable();
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
    Schema::dropIfExists('payments');
  }
};
