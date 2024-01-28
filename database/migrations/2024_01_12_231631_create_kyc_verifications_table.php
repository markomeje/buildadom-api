<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Enums\Kyc\KycVerificationStatusEnum;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('kyc_verifications', function (Blueprint $table) {
      $table->id();
      $table->string('id_type');
      $table->string('fullname')->nullable();
      $table->foreignId('document_type_id')->nullable()->references('id')->on('document_types');
      $table->bigInteger('id_number');
      $table->foreignId('citizenship_country')->nullable()->references('id')->on('supported_countries');
      $table->string('document_expiry_date');
      $table->string('state')->nullable();
      $table->string('birth_date');
      $table->foreignId('birth_country')->nullable()->references('id')->on('supported_countries');
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
    Schema::dropIfExists('kyc_verifications');
  }
};
