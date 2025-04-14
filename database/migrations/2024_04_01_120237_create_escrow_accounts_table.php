<?php

declare(strict_types=1);

use App\Enums\Escrow\EscrowAccountStatusEnum;
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
        Schema::create('escrow_accounts', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->foreignId('currency_id')->nullable()->references('id')->on('currencies');
            $table->decimal('balance', 18, 2);
            $table->text('extras')->nullable();
            $table->string('status')->default(EscrowAccountStatusEnum::ACTIVE->value);
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
        Schema::dropIfExists('escrow_accounts');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
};
