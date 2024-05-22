<?php

namespace App\Jobs\V1;

use App\Enums\Queue\QueueEnum;
use App\Enums\Sms\SmsStatusEnum;
use App\Integrations\Termii;
use App\Models\SmsLog;
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
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct(private int $log_id)
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
    $smsLog = SmsLog::query()->find($this->log_id);
    if (empty($smsLog)) {
      return;
    }

    try {
      if ($smsLog->status !== SmsStatusEnum::PENDING->value) {
        return;
      }

      $sent = (new Termii())->setPhone($smsLog->phone)
        ->setMessage($smsLog->message)
        ->send();

      if($sent) {
        $smsLog->status = SmsStatusEnum::SENT->value;
        $smsLog->save();
      }
    } catch (Exception $e) {
      $smsLog->status = SmsStatusEnum::ERROR->value;
      $smsLog->error_message = $e->getMessage();
      $smsLog->save();
    }

  }
}
