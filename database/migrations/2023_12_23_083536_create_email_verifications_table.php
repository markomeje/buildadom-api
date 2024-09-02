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
    Schema::create('email_verifications', function (Blueprint $table) {
      $table->id();
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
    Schema::dropIfExists('email_verifications');
  }
};
