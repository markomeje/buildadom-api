<?php

declare(strict_types=1);

namespace App\Console\Commands;
use App\Notifications\SendTestEmailsNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendTestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:test-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send test email';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $emails = [
            'markomejeonline@gmail.com',
            'ostanleyokere@yahoo.com',
            'lotanna.obi@gmail.com',
            'ibekwekachi@gmail.com',
            'onwuamaeze@yahoo.com',
        ];

        Notification::route('mail', $emails)->notify(new SendTestEmailsNotification);

        return 0;
    }
}
