<?php

declare(strict_types=1);

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
        Schema::create('shipping_addresses', function (Blueprint $table)
        {
            $table->id();
            $table->string('street_address');
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->foreignId('city_id')->nullable()->references('id')->on('cities');
            $table->foreignId('country_id')->nullable()->references('id')->on('countries');
            $table->foreignId('state_id')->nullable()->references('id')->on('states');
            $table->string('zip_code');
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
        Schema::dropIfExists('shipping_addresses');
    }
};
