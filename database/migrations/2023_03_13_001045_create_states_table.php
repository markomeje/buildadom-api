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
    Schema::create('states', function (Blueprint $table) {
      $table->id();
      $table->foreignId('country_id')->nullable()->references('id')->on('countries');
      $table->string('name');
      $table->string('latitude')->nullable();
      $table->string('longitude')->nullable();
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
    Schema::dropIfExists('states');
    DB::statement('SET FOREIGN_KEY_CHECKS = 1');
  }
};
