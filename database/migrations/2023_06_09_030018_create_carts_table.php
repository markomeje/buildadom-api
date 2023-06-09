<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Enums\CartStatusEnum;
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
    Schema::create('carts', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->nullable()->references('id')->on('users');
      $table->enum('status', CartStatusEnum::array())->default(CartStatusEnum::ACTIVE->value);
      $table->string('quantity');
      $table->foreignId('product_id')->nullable()->references('id')->on('products');
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
    Schema::dropIfExists('carts');
  }
};
