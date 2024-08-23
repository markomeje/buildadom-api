<?php

use App\Enums\Order\OrderFulfillmentStatusEnum;
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
    Schema::create('order_fulfillments', function (Blueprint $table) {
      $table->id();
      $table->foreignId('order_id')->nullable()->references('id')->on('orders');
      $table->foreignId('customer_id')->nullable()->references('id')->on('users');
      $table->boolean('payment_processed')->default(0);
      $table->string('status')->default(OrderFulfillmentStatusEnum::PENDING->value);
      $table->integer('confirmation_code')->nullable();
      $table->boolean('is_confirmed')->default(0);
      $table->timestamp('confirmed_at')->nullable();
      $table->string('reference')->unique();
      $table->boolean('payment_authorized')->default(0);
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
    Schema::dropIfExists('order_fulfillments');
  }
};
