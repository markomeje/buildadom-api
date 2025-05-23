<?php

use App\Enums\Business\BusinessProfileStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('business_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('website')->nullable();
            $table->string('cac_number')->nullable();

            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->string('status')->default(BusinessProfileStatusEnum::ACTIVE->value);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('business_profiles');
    }
};
