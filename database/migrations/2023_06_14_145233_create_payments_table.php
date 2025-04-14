<?php

declare(strict_types=1);

use App\Enums\Payment\PaymentStatusEnum;
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
        Schema::create('payments', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->foreignId('currency_id')->nullable()->references('id')->on('currencies');
            $table->string('status')->default(PaymentStatusEnum::INITIALIZED->value);
            $table->decimal('amount', 18, 2);
            $table->decimal('fee', 18, 2)->nullable();
            $table->decimal('total_amount', 18, 2);
            $table->string('type');
            $table->string('message')->nullable();
            $table->string('transfer_code')->nullable();
            $table->boolean('is_failed')->default(0);
            $table->string('reference')->unique()->index();
            $table->text('initialize_response')->nullable();
            $table->text('verify_response')->nullable();
            $table->text('webhook_response')->nullable();
            $table->text('payload')->nullable();
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
        Schema::dropIfExists('payments');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
};
