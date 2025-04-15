<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('dispatch_drivers', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->string('phone')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dispatch_drivers');
    }
};
