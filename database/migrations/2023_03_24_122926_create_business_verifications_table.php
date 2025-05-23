<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('business_verifications', function (Blueprint $table) {
            $table->id();
            $table->string('id_type');
            $table->string('fullname')->nullable();
            $table->bigInteger('id_number');
            $table->foreignId('citizenship_country')->nullable()->references('id')->on('countries');
            $table->string('expiry_date');
            $table->string('state')->nullable();
            $table->string('birth_date');
            $table->foreignId('birth_country')->nullable()->references('id')->on('countries');
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->string('address')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('business_verifications');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
