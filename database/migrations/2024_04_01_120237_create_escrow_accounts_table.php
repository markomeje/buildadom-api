<?php

use App\Enums\Escrow\EscrowAccountStatusEnum;
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
    Schema::create('escrow_accounts', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->nullable()->references('id')->on('users');
      $table->foreignId('payment_id')->nullable()->references('id')->on('payments');
      $table->bigInteger('total_amount');
      $table->text('extras')->nullable();
      $table->string('status')->default(EscrowAccountStatusEnum::PENDING->value);
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
    Schema::dropIfExists('escrow_accounts');
  }
};
