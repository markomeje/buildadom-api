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
    Schema::create('products', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('description');
      $table->foreignId('store_id')->nullable()->references('id')->on('stores');
      $table->string('status')->default('active');
      $table->foreignId('category_id')->nullable()->references('id')->on('categories');
      $table->float('price');
      $table->integer('quantity');
      $table->foreignId('user_id')->nullable()->references('id')->on('users');
      $table->string('attributes')->nullable();
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
    Schema::dropIfExists('products');
  }
};