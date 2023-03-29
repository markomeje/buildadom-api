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
    Schema::create('stores', function (Blueprint $table) {
      $table->id();
      $table->text('name');
      $table->foreignId('country_id')->nullable()->references('id')->on('countries');
      $table->text('description');
      $table->string('address');
      $table->boolean('active')->default(false);
      $table->foreignId('user_id')->nullable()->references('id')->on('users');
      $table->string('city')->nullable();
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
    Schema::dropIfExists('stores');
  }
};
