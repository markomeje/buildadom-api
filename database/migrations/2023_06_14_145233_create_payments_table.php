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
      $table->string('status')->default(PaymentStatusEnum::INITIALIZED->value);
      $table->decimal('amount', 16, 2);
      $table->foreignId('order_id')->nullable()->references('id')->on('orders');
      $table->string('type')->nullable();
      $table->string('reference')->unique();

      $table->string('authorization_code')->nullable();
      $table->text('payload')->nullable();
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
