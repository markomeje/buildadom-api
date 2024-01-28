<?php

use App\Enums\City\CityStatusEnum;
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
    Schema::create('cities', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('country_id');
      $table->foreignId('state_id')->nullable()->references('id')->on('states');
      $table->string('status')->default(CityStatusEnum::ACTIVE->value);
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
    Schema::dropIfExists('cities');
  }
};
