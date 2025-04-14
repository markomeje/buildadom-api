<?php

declare(strict_types=1);

use App\Enums\Product\ProductStatusEnum;
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
        Schema::create('products', function (Blueprint $table)
        {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->foreignId('store_id')->nullable()->references('id')->on('stores');
            $table->string('status')->default(ProductStatusEnum::ACTIVE->value);
            $table->foreignId('product_category_id')->nullable()->references('id')->on('product_categories');
            $table->bigInteger('price');
            $table->foreignId('currency_id')->nullable()->references('id')->on('currencies');
            $table->integer('quantity')->default(1);
            $table->boolean('published')->default(false);
            $table->foreignId('product_unit_id')->nullable()->references('id')->on('product_units');
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->string('tags')->nullable();
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('products');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
