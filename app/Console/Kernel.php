<?php

namespace App\Console;
use App\Jobs\Escrow\CreditEscrowAccountJob;
use App\Jobs\Order\CustomerPendingOrderReminderJob;
use App\Jobs\Order\UpdateCustomerOrderPaymentDetailsJob;
use App\Jobs\Payment\CreatePaystackTransferRecipientJob;
use App\Jobs\Payment\PaystackPaymentVerificationJob;
use App\Jobs\Payment\VerifyPaystackTransferPaymentJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        if (app()->environment(['local'])) {
            $schedule->job(new VerifyPaystackTransferPaymentJob)->everyMinute();
            $schedule->job(new PaystackPaymentVerificationJob)->everyMinute();
        }

        $schedule->job(new CreditEscrowAccountJob)->everyMinute();
        $schedule->job(new CreatePaystackTransferRecipientJob)->everyMinute();
        $schedule->job(new UpdateCustomerOrderPaymentDetailsJob)->everyMinute();
        $schedule->job(new CustomerPendingOrderReminderJob)->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
