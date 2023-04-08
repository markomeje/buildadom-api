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
      Schema::create('shippings', function (Blueprint $table) {
         $table->id();
         $table->string('street_address');
         $table->foreignId('user_id')->nullable()->references('id')->on('users');
         $table->string('city');
         $table->foreignId('order_id')->nullable()->references('id')->on('orders');
         $table->foreignId('country_id')->nullable()->references('id')->on('countries');
         $table->string('state');
         $table->string('zip_code');
         $table->string('status')->default('');
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
      Schema::dropIfExists('shippings');
   }
};
