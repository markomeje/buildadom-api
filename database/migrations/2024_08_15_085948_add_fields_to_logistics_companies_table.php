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
    Schema::table('logistics_companies', function (Blueprint $table) {
      $table->string('name')->index()->nullable()->after('id');
      $table->datetime('verified_at')->nullable()->after('status');
      $table->boolean('is_verified')->index()->default(0)->after('status');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('logistics_companies', function (Blueprint $table) {
      $table->dropColumn('name');
      $table->dropColumn('is_verified');
      $table->dropColumn('verified_at');
    });
  }
};
