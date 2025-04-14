<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('countries', function (Blueprint $table)
        {
            $table->id();
            $table->string('region');
            $table->string('name');
            $table->string('capital');
            $table->string('phone_code');
            $table->string('sub_region');
            $table->text('timezones')->nullable();
            $table->text('translations')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->string('emoji')->nullable();
            $table->string('flag_url')->nullable();
            $table->string('iso3');
            $table->string('iso2');
            $table->boolean('is_supported')->default(0);
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
        Schema::dropIfExists('countries');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
