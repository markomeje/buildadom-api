<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('product_units', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('product_units');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
