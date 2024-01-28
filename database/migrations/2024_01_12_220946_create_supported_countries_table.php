<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Enums\Country\SupportedCountryStatusEnum;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('supported_countries', function (Blueprint $table) {
      $table->id();
      $table->foreignId('country_id')->nullable()->references('id')->on('countries');
      $table->string('status')->default(SupportedCountryStatusEnum::ACTIVE->value);
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
    Schema::dropIfExists('supported_countries');
  }
};
