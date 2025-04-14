<?php

declare(strict_types=1);

use App\Enums\Order\OrderTrackingStatusEnum;
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
        Schema::create('order_trackings', function (Blueprint $table)
        {
            $table->id();
            $table->string('status')->default(OrderTrackingStatusEnum::PENDING->value);
            $table->foreignId('order_id')->nullable()->references('id')->on('orders');
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
        Schema::dropIfExists('order_trackings');
    }
};
