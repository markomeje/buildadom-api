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
    Schema::create('bank_accounts', function (Blueprint $table) {
      $table->id();
      $table->string('account_name');
      $table->foreignId('user_id')->nullable()->references('id')->on('users');
      $table->foreignId('nigerian_bank_id')->nullable()->references('id')->on('nigerian_banks');
      $table->string('bank_code')->nullable();
      $table->string('recipient_code')->nullable();
      $table->string('type')->default('nuban');
      $table->boolean('transfer_recipient_created')->default(0);
      $table->string('currency')->default('NGN');
      $table->string('account_number');
      $table->string('bank_name');
      $table->text('extras')->nullable();
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
    Schema::dropIfExists('bank_accounts');
  }
};
