<?php

use App\Enums\Payment\TransferPaymentStatusEnum;
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
    Schema::create('transfer_payments', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->nullable()->references('id')->on('users');
      $table->foreignId('currency_id')->nullable()->references('id')->on('currencies');
      $table->decimal('amount', 18, 2);
      $table->string('reference')->unique();
      $table->string('status')->default(TransferPaymentStatusEnum::PENDING->value);
      $table->string('message')->nullable();
      $table->string('transfer_code')->nullable();
      $table->boolean('is_failed')->default(0);
      $table->text('response')->nullable();
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
    Schema::dropIfExists('transfer_payments');
  }
};
