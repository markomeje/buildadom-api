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
    Schema::create('nigerian_banks', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('code');
      $table->boolean('is_active')->default(1);
      $table->string('slug')->nullable();
      $table->string('ussd')->nullable();
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
    Schema::dropIfExists('nigerian_banks');
  }
};
