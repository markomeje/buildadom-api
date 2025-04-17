<?php

namespace App\Jobs;
use App\Enums\Queue\QueueEnum;
use App\Enums\Sms\SmsStatusEnum;
use App\Exceptions\SendSmsException;
use App\Models\SmsLog;
use App\Models\User;
use App\Partners\TermiiSms;
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
     * @param  string  $phone
     * @param  string  $message
     * @param  \App\Models\User|null  $user
     */
    public function __construct(private string $phone, private string $message, private ?User $user)
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
        $smsLog = SmsLog::query()->create([
            'user_id' => optional($this->user)->id,
            'phone' => formatPhoneNumber($this->phone),
            'message' => $this->message,
            'status' => SmsStatusEnum::PENDING->value,
            'from' => config('services.termii.sender_id'),
        ]);

        try {
            (new TermiiSms)
                ->setPhone($smsLog->phone)
                ->setMessage($smsLog->message)
                ->send();

            if ($smsLog) {
                $smsLog->status = SmsStatusEnum::SENT->value;
                $smsLog->save();
            }
        } catch (Exception|SendSmsException $e) {
            $smsLog->status = SmsStatusEnum::ERROR->value;
            $smsLog->error_message = $e->getMessage();
            $smsLog->save();
        }

    }
}
