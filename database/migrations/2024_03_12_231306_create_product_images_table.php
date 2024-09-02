<?php

use App\Enums\Product\ProductImageRoleEnum;
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
    Schema::create('product_images', function (Blueprint $table) {
      $table->id();
      $table->string('url');
      $table->foreignId('product_id')->nullable()->references('id')->on('products');
      $table->foreignId('user_id')->nullable()->references('id')->on('users');
      $table->text('extras')->nullable();
      $table->string('role')->default(ProductImageRoleEnum::MAIN->value);
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
    Schema::dropIfExists('product_images');
  }
};
