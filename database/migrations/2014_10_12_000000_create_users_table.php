<?php

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
      Schema::create('users', function (Blueprint $table) {
         $table->id();
         $table->string('firstname')->nullable();
         $table->string('lastname')->nullable();

         $table->string('google_id')->nullable();
         $table->string('apple_id')->nullable();

         $table->string('type');
         $table->string('address')->nullable();
         $table->string('email')->unique();
         $table->string('phone')->unique();
         $table->string('password')->nullable();
         $table->string('status')->default('active');
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
      Schema::dropIfExists('users');
   }
};
