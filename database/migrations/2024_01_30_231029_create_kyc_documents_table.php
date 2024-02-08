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
    Schema::create('kyc_documents', function (Blueprint $table) {
      $table->id();
      $table->string('fullname')->nullable();
      $table->foreignId('kyc_verification_id')->nullable()->references('id')->on('kyc_verifications');
      $table->string('document_side');
      $table->string('document_file');
      $table->string('extras')->nullable();
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
    Schema::dropIfExists('kyc_documents');
  }
};
