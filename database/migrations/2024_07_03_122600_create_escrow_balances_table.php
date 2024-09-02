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
    Schema::create('escrow_balances', function (Blueprint $table) {
      $table->id();
      $table->foreignId('escrow_account_id')->nullable()->references('id')->on('escrow_accounts');
      $table->foreignId('user_id')->nullable()->references('id')->on('users');
      $table->decimal('old_balance', 18, 2);
      $table->decimal('amount', 18, 2);
      $table->decimal('new_balance', 18, 2);
      $table->string('balance_type');
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
    Schema::dropIfExists('escrow_balances');
  }
};
