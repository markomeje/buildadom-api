<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('supported_countries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->nullable()->references('id')->on('countries');
            $table->timestamps();
        });
    }

    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('supported_countries');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
