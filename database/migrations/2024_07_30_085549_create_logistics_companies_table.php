<?php

use App\Enums\Logistics\LogisticsCompanyStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('logistics_companies', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number');
            $table->string('name')->index()->nullable();
            $table->foreignId('state_id')->nullable()->references('id')->on('states');
            $table->foreignId('country_id')->nullable()->references('id')->on('countries');
            $table->foreignId('currency_id')->nullable()->references('id')->on('currencies');
            $table->string('drivers_license')->nullable();
            $table->string('vehicle_picture')->nullable();
            $table->string('driver_picture')->nullable();
            $table->foreignId('city_id')->nullable()->references('id')->on('cities');
            $table->string('phone_number');
            $table->decimal('base_price', 18, 2);
            $table->string('park_address')->nullable();
            $table->string('office_address')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('status')->default(LogisticsCompanyStatusEnum::UNVERIFIED->value);
            $table->string('extras')->nullable();
            $table->datetime('verified_at')->nullable();
            $table->boolean('is_verified')->index()->default(0);
            $table->string('reference')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('logistics_companies');
    }
};
