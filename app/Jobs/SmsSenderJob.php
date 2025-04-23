<?php

namespace App\Jobs;
use App\Contracts\SmsSenderInterface;
use App\Enums\Queue\QueueEnum;
use App\Enums\Sms\SmsProviderNameEnum;
use App\Enums\Sms\SmsStatusEnum;
use App\Exceptions\SendSmsException;
use App\Models\SmsLog;
use App\Models\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SmsSenderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param \App\Contracts\SmsSenderInterface $smsSender
     * @param string $phone
     * @param string $message
     * @param mixed $user
     */
    public function __construct(private SmsSenderInterface $smsSender, private string $phone, private string $message, private ?User $user)
    {
        $this->onQueue(QueueEnum::SMS->value);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $log = SmsLog::query()->create([
            'user_id' => optional($this->user)->id,
            'phone' => formatPhoneNumber($this->phone),
            'message' => $this->message,
            'status' => SmsStatusEnum::PENDING->value,
            'from' => SmsProviderNameEnum::TERMII->value,
        ]);

        try {
            $this->smsSender->setPhone($log->phone)
                ->setMessage($log->message)
                ->send();

            if ($log) {
                $log->status = SmsStatusEnum::SENT->value;
                $log->save();
            }
        } catch (Exception|SendSmsException $e) {
            $log->status = SmsStatusEnum::ERROR->value;
            $log->error_message = $e->getMessage();
            $log->save();
        }
    }
}
