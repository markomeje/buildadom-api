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
    Schema::create('fee_settings', function (Blueprint $table) {
      $table->id();
      $table->foreignId('currency_id')->nullable()->references('id')->on('currencies');
      $table->string('type');
      $table->decimal('amount', 18, 2);
      $table->string('code');
      $table->string('description')->nullable();
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
    Schema::dropIfExists('fee_settings');
  }
};
