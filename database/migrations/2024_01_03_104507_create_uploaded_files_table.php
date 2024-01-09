<?php

use Illuminate\Support\Facades\Schema;
use App\Enums\File\UploadedFileRoleEnum;
use Illuminate\Database\Schema\Blueprint;
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
    Schema::create('uploaded_files', function (Blueprint $table) {
      $table->id();
      $table->string('url');
      $table->string('extras')->nullable();
      $table->morphs('uploadable');
      $table->string('file_type')->nullable();
      $table->foreignId('user_id')->nullable()->references('id')->on('users');
      $table->string('role')->default(UploadedFileRoleEnum::MAIN->value);
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
    Schema::dropIfExists('uploaded_files');
  }
};
