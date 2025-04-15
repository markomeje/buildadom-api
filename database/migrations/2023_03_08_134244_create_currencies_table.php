<?php

use App\Enums\Currency\CurrencyStatusEnum;
use App\Enums\Currency\CurrencyTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('symbol')->nullable();
            $table->string('type')->default(CurrencyTypeEnum::FIAT->value);
            $table->string('status')->default(CurrencyStatusEnum::ACTIVE->value);
            $table->string('name');
            $table->string('icon')->nullable();
            $table->boolean('is_supported')->default(0);
            $table->boolean('is_default')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('currencies');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
