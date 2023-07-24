<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Enums\V1\Order\OrderTrackingStatusEnum;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('order_trackings', function (Blueprint $table) {
      $table->id();
      $table->enum('status', OrderTrackingStatusEnum::array())->default(OrderTrackingStatusEnum::PENDING->value);
      $table->foreignId('order_item_id')->nullable()->references('id')->on('order_items');
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
    Schema::dropIfExists('order_trackings');
  }
};
