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
    Schema::create('business_verifications', function (Blueprint $table) {
      $table->id();
      $table->string('id_type');
      $table->string('fullname')->nullable();
      $table->bigInteger('id_number');
      $table->string('citizenship_country')->nullable();
      $table->string('expiry_date');
      $table->string('state')->nullable();
      $table->string('dob');
      $table->string('birth_country')->nullable();
      $table->string('type');
      $table->foreignId('user_id')->nullable()->references('id')->on('users');
      $table->string('address')->nullable();
      $table->boolean('verified')->default(false);
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
    Schema::dropIfExists('business_verifications');
  }
};
