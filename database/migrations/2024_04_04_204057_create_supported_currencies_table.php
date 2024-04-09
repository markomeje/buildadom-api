<?php

use App\Enums\Currency\CurrencyTypeEnum;
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
    Schema::create('supported_currencies', function (Blueprint $table) {
      $table->id();
      $table->string('code');
      $table->string('symbol')->nullable();
      $table->string('type')->default(CurrencyTypeEnum::FIAT->value);
      $table->string('name');
      $table->string('icon')->nullable();
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
    Schema::dropIfExists('supported_currencies');
  }
};
