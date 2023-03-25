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
    Schema::create('identifications', function (Blueprint $table) {
      $table->id();
      $table->string('id_type');
      $table->bigInteger('id_number');
      $table->string('expiry_date');
      $table->string('dob');
      $table->foreignId('user_id')->nullable()->references('id')->on('users');
      $table->string('address');
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
    Schema::dropIfExists('identifications');
  }
};
