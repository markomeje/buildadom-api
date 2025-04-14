<?php

declare(strict_types=1);

use App\Enums\Store\StoreStatusEnum;
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
        Schema::create('stores', function (Blueprint $table)
        {
            $table->id();
            $table->text('name');
            $table->text('logo')->nullable();
            $table->text('banner')->nullable();
            $table->foreignId('country_id')->nullable()->references('id')->on('countries');
            $table->foreignId('city_id')->nullable()->references('id')->on('cities');
            $table->foreignId('state_id')->nullable()->references('id')->on('states');
            $table->text('description');
            $table->boolean('published')->default(false);
            $table->string('address');
            $table->text('extras')->nullable();
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->string('status')->default(StoreStatusEnum::ACTIVE->value);
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
        Schema::dropIfExists('stores');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
