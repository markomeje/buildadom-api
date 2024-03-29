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
    Schema::create('images', function (Blueprint $table) {
      $table->id();
      $table->string('url');
      $table->string('filename')->nullable();
      $table->string('model');
      $table->string('extension')->nullable();
      $table->foreignId('model_id');
      $table->foreignId('user_id')->nullable()->references('id')->on('users');
      $table->string('role')->nullable();
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
    Schema::dropIfExists('images');
  }

};
