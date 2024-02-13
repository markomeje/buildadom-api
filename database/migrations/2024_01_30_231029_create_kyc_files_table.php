<?php

use App\Enums\Kyc\KycFileStatusEnum;
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
    Schema::create('kyc_files', function (Blueprint $table) {
      $table->id();
      $table->string('description');
      $table->foreignId('user_id')->nullable()->references('id')->on('users');
      $table->string('file_side');
      $table->foreignId('kyc_verification_id')->nullable()->references('id')->on('kyc_verifications');
      $table->string('uploaded_file');
      $table->string('status')->default(KycFileStatusEnum::PENDING->value);
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
    Schema::dropIfExists('kyc_files');
  }
};
