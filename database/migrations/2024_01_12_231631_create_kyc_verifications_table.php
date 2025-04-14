<?php

declare(strict_types=1);

use App\Enums\Kyc\KycVerificationStatusEnum;
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
        Schema::create('kyc_verifications', function (Blueprint $table)
        {
            $table->id();
            $table->string('fullname')->nullable();
            $table->foreignId('document_type_id')->nullable()->references('id')->on('document_types');
            $table->bigInteger('document_number');
            $table->foreignId('citizenship_country')->nullable()->references('id')->on('countries');
            $table->string('document_expiry_date');
            $table->string('birth_date');
            $table->foreignId('birth_country')->nullable()->references('id')->on('countries');
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->string('address')->nullable();
            $table->string('status')->default(KycVerificationStatusEnum::PENDING->value);
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        Schema::dropIfExists('kyc_verifications');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
};
