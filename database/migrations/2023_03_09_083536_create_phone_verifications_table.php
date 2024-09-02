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
    Schema::create('phone_verifications', function (Blueprint $table) {
      $table->id();
      $table->string('sender_id')->nullable();
      $table->boolean('verified')->default(false);
      $table->string('code')->nullable();
      $table->foreignId('user_id')->nullable()->references('id')->on('users');
      $table->dateTime('expiry')->nullable();
      $table->dateTime('verified_at')->nullable();
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
    Schema::dropIfExists('phone_verifications');
  }
};
