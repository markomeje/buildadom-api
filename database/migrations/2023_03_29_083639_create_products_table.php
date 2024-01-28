<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
      $table->text('description');
      $table->foreignId('store_id')->nullable()->references('id')->on('stores');
      $table->string('status')->default('active');
      $table->foreignId('category_id')->nullable()->references('id')->on('categories');
      $table->float('price');
      $table->foreignId('currency_id')->nullable()->references('id')->on('currencies');
      $table->integer('quantity');
      $table->boolean('published')->default(false);
      $table->foreignId('unit_id')->nullable()->references('id')->on('product_units');
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
    DB::statement('SET FOREIGN_KEY_CHECKS = 0');
    Schema::dropIfExists('products');
    DB::statement('SET FOREIGN_KEY_CHECKS = 1');
  }
};
